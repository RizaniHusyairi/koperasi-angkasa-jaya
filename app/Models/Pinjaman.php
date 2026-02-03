<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'jumlah_pinjaman',
        'sisa_pinjaman',
        'tenor',
        'bunga',
        'tanggal_pinjaman',
        'tanggal_jatuh_tempo',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjaman' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'jumlah_pinjaman' => 'decimal:2',
        'sisa_pinjaman' => 'decimal:2',
        'bunga' => 'decimal:2',
    ];

    /**
     * Get the anggota that owns the pinjaman.
     */
    /**
     * Get the anggota that owns the pinjaman.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    /**
     * Get the angsuran for the pinjaman.
     */
    public function angsuran()
    {
        return $this->hasMany(Angsuran::class);
    }

    /**
     * Calculate monthly installment.
     */
    /**
     * Calculate monthly installment.
     */
    public function getAngsuranBulananAttribute()
    {
        if ($this->tenor <= 0) {
            return 0;
        }
        $totalBunga = $this->jumlah_pinjaman * ($this->bunga / 100);
        return ($this->jumlah_pinjaman + $totalBunga) / $this->tenor;
    }

    /**
     * Get total pinjaman (Calculated from Remaining + Paid History).
     * This ensures consistency even if initial data was messy.
     */
    public function getTotalPinjamanAttribute()
    {
        return $this->sisa_pinjaman + $this->angsuran->sum('jumlah_bayar');
    }
}
