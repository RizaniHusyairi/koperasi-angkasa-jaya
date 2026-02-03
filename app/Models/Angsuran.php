<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    protected $table = 'angsuran';

    protected $fillable = [
        'pinjaman_id',
        'angsuran_ke',
        'jumlah_bayar',
        'denda',
        'tanggal_bayar',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah_bayar' => 'decimal:2',
        'denda' => 'decimal:2',
    ];

    /**
     * Get the pinjaman that owns the angsuran.
     */
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
