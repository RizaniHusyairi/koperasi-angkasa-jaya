<?php

namespace Database\Seeders;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AngsuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Get random active loans
        $loans = Pinjaman::where('status', 'Aktif')->inRandomOrder()->take(5)->get();

        foreach ($loans as $loan) {
            // Determine how many payments to simulate (1 to 5)
            $paymentsCount = rand(1, 5);
            $monthlyInstallment = $loan->angsuran_bulanan;

            for ($i = 1; $i <= $paymentsCount; $i++) {
                // Ensure we don't overpay (check remaining balance)
                if ($loan->sisa_pinjaman < $monthlyInstallment) {
                    break;
                }

                $date = now()->subMonths($paymentsCount - $i);
                
                // Add some denda occasionally
                $denda = rand(0, 5) == 0 ? 50000 : 0;

                Angsuran::create([
                    'pinjaman_id' => $loan->id,
                    'angsuran_ke' => $i,
                    'jumlah_bayar' => $monthlyInstallment,
                    'denda' => $denda,
                    'tanggal_bayar' => $date,
                    'keterangan' => 'Pembayaran angsuran ke-' . $i . ' (Dummy Data)',
                ]);

                // Update loan remaining balance
                $loan->sisa_pinjaman -= $monthlyInstallment;
                $loan->save();
            }
        }
    }
}
