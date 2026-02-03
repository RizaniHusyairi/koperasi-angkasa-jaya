<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anggota;
use App\Models\SimpananPokok;
use App\Models\SimpananWajib;
use App\Models\Pinjaman;
use App\Models\Tabungan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AnggotaSeeder extends Seeder
{
    private $bulanMap = [
        'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04',
        'MEI' => '05', 'JUN' => '06', 'JUL' => '07', 'AGU' => '08',
        'SEP' => '09', 'OKT' => '10', 'NOV' => '11', 'DES' => '12'
    ];

    public function run(): void
    {
        // Read Excel file
        $spreadsheet = IOFactory::load(base_path('public/assets/anggota_koperasi.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Skip header row
        $isFirst = true;
        foreach ($data as $row) {
            if ($isFirst) {
                $isFirst = false;
                continue;
            }

            // Skip empty rows
            if (empty($row[0]) || !is_numeric($row[0])) {
                continue;
            }

            $no = (int) $row[0];
            $statusPegawai = trim($row[1] ?? 'PNS');
            $nama = $this->formatNama(trim($row[2] ?? ''));
            $nomorAnggota = str_replace(' ', '', trim($row[3] ?? ''));
            $nomorUrut = str_pad($row[4] ?? $no, 3, '0', STR_PAD_LEFT);
            $tahun = $row[5] ?? '2020';
            $bulan = $this->bulanMap[strtoupper(trim($row[6] ?? 'JAN'))] ?? '01';
            $kodeSp = $row[7] ?? '1';
            $statusKeanggotaan = strpos(strtoupper($row[8] ?? ''), 'KELUAR') !== false ? 'Tidak Aktif' : 'Aktif';

            // Generate email from nama
            $email = $this->generateEmail($nama, $no);

            // Skip if user already exists
            if (User::where('email', $email)->exists()) {
                continue;
            }

            // Create user account
            $user = User::create([
                'name' => $nama,
                'email' => $email,
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('anggota');

            // Create anggota record
            $anggota = Anggota::create([
                'user_id' => $user->id,
                'nomor_wa' => $this->generateNomorWa(),
                'nomor_anggota' => $nomorAnggota,
                'nomor_urut' => (int) $nomorUrut,
                'tanggal_gabung' => "{$tahun}-{$bulan}-01",
                'kode_sp' => $kodeSp,
                'status_pegawai' => $statusPegawai,
                'status_keanggotaan' => $statusKeanggotaan,
                'limit_pinjaman' => $this->getLimitByStatus($statusPegawai),
                'simpanan_pokok' => 100000,
                'simpanan_wajib' => 50000,
            ]);

            // Create initial simpanan pokok
            SimpananPokok::create([
                'anggota_id' => $anggota->id,
                'tanggal' => "{$tahun}-{$bulan}-01",
                'jumlah' => 100000,
                'keterangan' => 'Simpanan pokok awal',
            ]);

            // Create simpanan wajib for random months
            $this->createSimpananWajib($anggota, $tahun, $bulan);

            // Create tabungan account
            $saldoTabungan = rand(0, 50) * 100000; // 0 - 5jt
            Tabungan::create([
                'anggota_id' => $anggota->id,
                'saldo' => $saldoTabungan,
            ]);

            // Create pinjaman for some anggota (random)
            if (rand(1, 100) <= 40 && $statusKeanggotaan == 'Aktif') { // 40% chance
                $this->createPinjaman($anggota);
            }
        }
    }

    private function formatNama(string $nama): string
    {
        // Convert to title case
        return ucwords(strtolower($nama));
    }

    private function generateEmail(string $nama, int $no): string
    {
        // Create email from nama
        $email = strtolower(str_replace(' ', '.', $nama));
        $email = preg_replace('/[^a-z0-9.]/', '', $email);
        return "{$email}@koperasi.aptpairport.id";
    }

    private function generateNomorWa(): string
    {
        // 08xx-xxxx-xxxx
        return '08' . rand(11, 99) . '-' . rand(1111, 9999) . '-' . rand(1111, 9999);
    }

    private function getLimitByStatus(string $statusPegawai): int
    {
        return match ($statusPegawai) {
            'PNS' => 100000000, // 100jt
            'P3K' => 50000000,  // 50jt
            'PPNPN' => 25000000, // 25jt
            default => 50000000,
        };
    }

    private function createSimpananWajib(Anggota $anggota, string $tahunGabung, string $bulanGabung): void
    {
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "{$tahunGabung}-{$bulanGabung}-01");
        $endDate = \Carbon\Carbon::now();
        
        // Create simpanan wajib for each month since joining
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            SimpananWajib::create([
                'anggota_id' => $anggota->id,
                'bulan' => $current->format('Y-m-01'),
                'tanggal' => $current->format('Y-m-15'),
                'jumlah' => 50000,
                'keterangan' => 'Simpanan wajib bulanan',
            ]);
            $current->addMonth();
        }
    }

    private function createPinjaman(Anggota $anggota): void
    {
        $jumlahPinjaman = rand(1, 10) * 5000000; // 5jt - 50jt
        $tenor = [12, 24, 36][rand(0, 2)]; 
        $bunga = 0.25; // 0.25% per month
        
        // Random start date within last 12 months
        $tanggalPinjaman = \Carbon\Carbon::now()->subMonths(rand(1, 12));
        
        // Calculate total debt (principal + flat interest)
        $totalBunga = $jumlahPinjaman * ($bunga / 100) * $tenor;
        $totalHutang = $jumlahPinjaman + $totalBunga;
        $angsuranPerBulan = $totalHutang / $tenor;
        
        // Calculate months elapsed
        $bulanBerjalan = \Carbon\Carbon::now()->diffInMonths($tanggalPinjaman);
        
        // Create Pinjaman Record first (Full Amount)
        $pinjaman = Pinjaman::create([
            'anggota_id' => $anggota->id,
            'tanggal_pinjaman' => $tanggalPinjaman,
            'jumlah_pinjaman' => $jumlahPinjaman,
            'tenor' => $tenor,
            'bunga' => $bunga,
            'sisa_pinjaman' => $totalHutang, // Initialize with FULL Total
            'tanggal_jatuh_tempo' => $tanggalPinjaman->copy()->addMonths($tenor),
            'status' => 'Aktif',
        ]);

        // Create Angsuran for past months
        for ($i = 1; $i <= $bulanBerjalan; $i++) {
            $tanggalBayar = $tanggalPinjaman->copy()->addMonths($i);
            
            // Should not exceed repayment
            if ($pinjaman->sisa_pinjaman < $angsuranPerBulan) {
                $pinjaman->status = 'Lunas';
                $pinjaman->save();
                break;
            }

            \App\Models\Angsuran::create([
               'pinjaman_id' => $pinjaman->id,
               'angsuran_ke' => $i,
               'jumlah_bayar' => $angsuranPerBulan,
               'denda' => 0,
               'tanggal_bayar' => $tanggalBayar,
               'keterangan' => 'Angsuran Bulanan (Auto-seed)',
            ]);

            $pinjaman->sisa_pinjaman -= $angsuranPerBulan;
        }

        // Update Final Status
        if ($pinjaman->sisa_pinjaman <= 0) {
            $pinjaman->sisa_pinjaman = 0;
            $pinjaman->status = 'Lunas';
        }
        $pinjaman->save();
    }
}
