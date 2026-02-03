<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'nomor_wa',
        'nomor_anggota',
        'nomor_urut',
        'tanggal_gabung',
        'kode_sp',
        'status_pegawai',
        'status_keanggotaan',
        'limit_pinjaman',
        'simpanan_pokok',
        'simpanan_wajib',
        'jumlah_belanja_minimarket',
    ];

    protected $casts = [
        'tanggal_gabung' => 'date',
        'limit_pinjaman' => 'decimal:2',
        'simpanan_pokok' => 'decimal:2',
        'simpanan_wajib' => 'decimal:2',
        'jumlah_belanja_minimarket' => 'decimal:2',
    ];

    /**
     * Generate nomor anggota automatically.
     * Format: {nomor_urut}{tahun}{bulan}{kode_sp}
     * Example: 00120251SP
     */
    public static function generateNomorAnggota(int $nomorUrut, string $tanggalGabung, string $kodeSp = 'SP'): string
    {
        $date = \Carbon\Carbon::parse($tanggalGabung);
        $urut = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        $tahun = $date->format('Y');
        $bulan = $date->format('m');
        
        return $urut . $tahun . $bulan . $kodeSp;
    }

    /**
     * Get the user that owns the anggota.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the simpanan pokok records.
     */
    public function simpananPokok()
    {
        return $this->hasMany(SimpananPokok::class);
    }

    /**
     * Get the simpanan wajib records.
     */
    public function simpananWajib()
    {
        return $this->hasMany(SimpananWajib::class);
    }

    /**
     * Get the pinjaman records.
     */
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    /**
     * Get the tabungan record.
     */
    public function tabungan()
    {
        return $this->hasOne(Tabungan::class);
    }

    /**
     * Get the pengajuan pinjaman records.
     */
    public function pengajuanPinjaman()
    {
        return $this->hasMany(PengajuanPinjaman::class);
    }

    /**
     * Get total simpanan pokok.
     */
    public function getTotalSimpananPokokAttribute()
    {
        return $this->simpananPokok()->sum('jumlah');
    }

    /**
     * Get total simpanan wajib.
     */
    public function getTotalSimpananWajibAttribute()
    {
        return $this->simpananWajib()->sum('jumlah');
    }

    /**
     * Get total sisa pinjaman (hutang termasuk bunga).
     * Digunakan untuk menampilkan total hutang yang harus dilunasi.
     */
    public function getTotalSisaPinjamanAttribute()
    {
        return $this->pinjaman()->where('status', 'Aktif')->sum('sisa_pinjaman');
    }

    /**
     * Get total pokok pinjaman aktif.
     * Digunakan untuk menghitung limit pinjaman terpakai.
     */
    public function getTotalPinjamanAktifAttribute()
    {
        return $this->pinjaman()->where('status', 'Aktif')->sum('jumlah_pinjaman');
    }

    /**
     * Get sisa limit pinjaman.
     */
    public function getSisaLimitPinjamanAttribute()
    {
        return max(0, $this->limit_pinjaman - $this->total_pinjaman_aktif);
    }
}
