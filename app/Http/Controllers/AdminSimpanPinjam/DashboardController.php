<?php

namespace App\Http\Controllers\AdminSimpanPinjam;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\PengajuanPinjaman;
use App\Models\Pinjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnggota = Anggota::where('status_keanggotaan', 'Aktif')->count();
        $totalPengajuanPending = PengajuanPinjaman::pending()->count();
        $totalPinjamanAktif = Pinjaman::where('status', 'Aktif')->count();
        $totalNilaiPinjamanAktif = Pinjaman::where('status', 'Aktif')->sum('sisa_pinjaman');

        return view('admin-simpan-pinjam.dashboard', compact(
            'totalAnggota',
            'totalPengajuanPending',
            'totalPinjamanAktif',
            'totalNilaiPinjamanAktif'
        ));
    }
}
