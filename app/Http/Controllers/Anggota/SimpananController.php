<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;

class SimpananController extends Controller
{
    public function pokok()
    {
        $anggota = auth()->user()->anggota;
        $simpananPokok = $anggota->simpananPokok()->orderBy('tanggal', 'desc')->paginate(10);
        $totalSimpananPokok = $anggota->total_simpanan_pokok;

        return view('anggota.simpanan.pokok', compact('simpananPokok', 'totalSimpananPokok'));
    }

    public function wajib()
    {
        $anggota = auth()->user()->anggota;
        $simpananWajib = $anggota->simpananWajib()->orderBy('tanggal', 'desc')->paginate(10);
        $totalSimpananWajib = $anggota->total_simpanan_wajib;

        return view('anggota.simpanan.wajib', compact('simpananWajib', 'totalSimpananWajib'));
    }
}
