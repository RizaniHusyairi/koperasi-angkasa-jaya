<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $anggota = $user->anggota;
        
        if (!$anggota) {
            return redirect()->route('login')->with('error', 'Data anggota tidak ditemukan.');
        }

        $anggota->load(['tabungan', 'pinjaman' => function ($query) {
            $query->where('status', 'Aktif');
        }]);

        $totalSimpananPokok = $anggota->total_simpanan_pokok;
        $totalSimpananWajib = $anggota->total_simpanan_wajib;
        $totalSisaPinjaman = $anggota->total_sisa_pinjaman;
        $saldoTabungan = $anggota->tabungan ? $anggota->tabungan->saldo : 0;

        // Fetch latest orders
        $latestOrders = \App\Models\Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('anggota.dashboard', compact(
            'anggota',
            'totalSimpananPokok',
            'totalSimpananWajib',
            'totalSisaPinjaman',
            'saldoTabungan',
            'latestOrders'
        ));
    }
}
