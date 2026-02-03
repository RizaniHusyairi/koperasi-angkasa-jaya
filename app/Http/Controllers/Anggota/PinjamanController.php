<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;

class PinjamanController extends Controller
{
    public function index()
    {
        $anggota = auth()->user()->anggota;
        $pinjaman = $anggota->pinjaman()->orderBy('tanggal_pinjaman', 'desc')->paginate(10);
        $totalSisaPinjaman = $anggota->total_sisa_pinjaman;

        return view('anggota.pinjaman.index', compact('pinjaman', 'totalSisaPinjaman'));
    }
}
