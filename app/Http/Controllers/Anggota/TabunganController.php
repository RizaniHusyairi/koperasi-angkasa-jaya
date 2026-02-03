<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;

class TabunganController extends Controller
{
    public function index()
    {
        $anggota = auth()->user()->anggota;
        $tabungan = $anggota->tabungan;

        return view('anggota.tabungan.index', compact('tabungan'));
    }
}
