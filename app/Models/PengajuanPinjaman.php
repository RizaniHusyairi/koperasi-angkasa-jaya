<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPinjaman extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pinjaman';

    protected $fillable = [
        'anggota_id',
        'jumlah_pengajuan',
        'tenor',
        'keperluan',
        'status',
        'approved_by',
        'tanggal_diproses',
        'catatan_admin',
    ];

    protected $casts = [
        'jumlah_pengajuan' => 'decimal:2',
        'tanggal_diproses' => 'datetime',
    ];

    /**
     * Get the anggota that owns the pengajuan.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    /**
     * Get the user who approved/rejected the pengajuan.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for pending pengajuan.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope for approved pengajuan.
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'Disetujui');
    }

    /**
     * Scope for rejected pengajuan.
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'Ditolak');
    }
}
