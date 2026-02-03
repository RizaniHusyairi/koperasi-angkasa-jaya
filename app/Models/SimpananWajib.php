<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananWajib extends Model
{
    use HasFactory;

    protected $table = 'simpanan_wajib';

    protected $fillable = [
        'anggota_id',
        'jumlah',
        'tanggal',
        'bulan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Get the anggota that owns the simpanan.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
