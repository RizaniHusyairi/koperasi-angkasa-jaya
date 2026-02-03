<?php

namespace App\Http\Controllers\SPV;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPegawai = Pegawai::count();

        return view('spv.dashboard', compact('totalPegawai'));
    }
}
