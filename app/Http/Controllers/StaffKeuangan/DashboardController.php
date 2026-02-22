<?php

namespace App\Http\Controllers\StaffKeuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total dari invoice
        $totalPendapatan = Invoice::sum('total_amount');

        return view('staff-keuangan.dashboard', compact('totalPendapatan'));
    }
}
