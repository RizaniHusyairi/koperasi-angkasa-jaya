<?php

namespace App\Http\Controllers\AdminSimpanPinjam;

use App\Http\Controllers\Controller;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AngsuranController extends Controller
{
    public function index(Request $request)
    {
        $angsuran = Angsuran::with(['pinjaman.anggota.user'])
            ->latest()
            ->paginate(10);

        return view('admin-simpan-pinjam.angsuran.index', compact('angsuran'));
    }

    public function create()
    {
        // Get active loans
        $pinjaman = Pinjaman::with(['anggota.user'])
            ->where('status', 'Aktif')
            ->where('sisa_pinjaman', '>', 0)
            ->get();

        return view('admin-simpan-pinjam.angsuran.create', compact('pinjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah_bayar' => 'required|numeric|min:1',
            'denda' => 'nullable|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $pinjaman = Pinjaman::findOrFail($request->pinjaman_id);

        if ($request->jumlah_bayar > $pinjaman->sisa_pinjaman) {
            return back()->with('error', 'Jumlah bayar melebihi sisa pinjaman (Rp ' . number_format($pinjaman->sisa_pinjaman, 0, ',', '.') . ')')->withInput();
        }

        DB::beginTransaction();
        try {
            // Determine angsuran ke-X
            $lastAngsuran = Angsuran::where('pinjaman_id', $pinjaman->id)->max('angsuran_ke');
            $angsuranKe = $lastAngsuran ? $lastAngsuran + 1 : 1;

            Angsuran::create([
                'pinjaman_id' => $pinjaman->id,
                'angsuran_ke' => $angsuranKe,
                'jumlah_bayar' => $request->jumlah_bayar,
                'denda' => $request->denda ?? 0,
                'tanggal_bayar' => $request->tanggal_bayar,
                'keterangan' => $request->keterangan,
            ]);

            // Update remaining loan balance
            $pinjaman->sisa_pinjaman -= $request->jumlah_bayar;
            
            // Check if fully paid
            if ($pinjaman->sisa_pinjaman <= 0) {
                $pinjaman->status = 'Lunas';
                $pinjaman->sisa_pinjaman = 0; // Ensure no negative balance
            }
            
            $pinjaman->save();

            DB::commit();

            return redirect()->route('admin-sp.angsuran.index')->with('success', 'Pembayaran angsuran berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
