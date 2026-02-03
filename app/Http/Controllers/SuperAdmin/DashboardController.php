<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
use App\Models\PengajuanPinjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAnggota = Anggota::count();
        $totalAnggotaAktif = Anggota::where('status_keanggotaan', 'Aktif')->count();
        $totalPengajuanPending = PengajuanPinjaman::pending()->count();

        // Monthly Stats (Cross-database compatible)
        $connection = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $dateFormat = $connection === 'sqlite' 
            ? "strftime('%Y-%m', tanggal_gabung)" 
            : "DATE_FORMAT(tanggal_gabung, '%Y-%m')";

        $monthlyStats = Anggota::selectRaw("$dateFormat as month, count(*) as count")
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->limit(12)
            ->pluck('count', 'month');

        // Latest Anggota
        $latestAnggota = Anggota::with('user')->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalAnggota',
            'totalAnggotaAktif',
            'totalPengajuanPending',
            'monthlyStats',
            'latestAnggota'
        ));
    }
}
