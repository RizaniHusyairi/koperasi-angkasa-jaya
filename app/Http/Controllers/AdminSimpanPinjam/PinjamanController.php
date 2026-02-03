<?php

namespace App\Http\Controllers\AdminSimpanPinjam;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Pinjaman::with('anggota.user');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('anggota', function($q) use ($search) {
                $q->where('nomor_anggota', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $pinjaman = $query->orderBy('tanggal_pinjaman', 'desc')->paginate(10);

        return view('admin-simpan-pinjam.pinjaman.index', compact('pinjaman', 'status'));
    }

    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load('anggota.user');
        return view('admin-simpan-pinjam.pinjaman.show', compact('pinjaman'));
    }
}
