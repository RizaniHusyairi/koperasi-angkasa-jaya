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
        
        $pinjaman = $query->orderBy('tanggal_pinjaman', 'desc')->get();

        return view('admin-simpan-pinjam.pinjaman.index', compact('pinjaman', 'status'));
    }

    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load('anggota.user');
        return view('admin-simpan-pinjam.pinjaman.show', compact('pinjaman'));
    }

    public function destroy(Pinjaman $pinjaman)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Delete associated installments first (though DB cascade might handle it, manual is safer here)
            $pinjaman->angsuran()->delete();
            
            // Delete the loan
            $pinjaman->delete();

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->back()->with('success', 'Data pinjaman dan riwayat angsuran berhasil dihapus.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
