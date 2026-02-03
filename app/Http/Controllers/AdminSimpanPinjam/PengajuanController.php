<?php

namespace App\Http\Controllers\AdminSimpanPinjam;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPinjaman;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = PengajuanPinjaman::with(['anggota.user', 'approver']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $pengajuan = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin-simpan-pinjam.pengajuan.index', compact('pengajuan', 'status'));
    }

    public function show(PengajuanPinjaman $pengajuan)
    {
        $pengajuan->load(['anggota.user', 'anggota.pinjaman', 'approver']);
        return view('admin-simpan-pinjam.pengajuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, PengajuanPinjaman $pengajuan)
    {
        if ($pengajuan->status !== 'Pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
            'bunga' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Update pengajuan status
            $pengajuan->update([
                'status' => 'Disetujui',
                'approved_by' => auth()->id(),
                'tanggal_diproses' => now(),
                'catatan_admin' => $validated['catatan_admin'],
            ]);

            // Calculate due date
            $tanggalJatuhTempo = now()->addMonths($pengajuan->tenor);
            
            $totalBunga = $pengajuan->jumlah_pengajuan * ($validated['bunga'] / 100);
            $sisaPinjaman = $pengajuan->jumlah_pengajuan + $totalBunga;

            // Create pinjaman record
            Pinjaman::create([
                'anggota_id' => $pengajuan->anggota_id,
                'jumlah_pinjaman' => $pengajuan->jumlah_pengajuan,
                'sisa_pinjaman' => $sisaPinjaman,
                'tenor' => $pengajuan->tenor,
                'bunga' => $validated['bunga'],
                'tanggal_pinjaman' => now(),
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'status' => 'Aktif',
            ]);

            DB::commit();

            return redirect()->route('admin-sp.pengajuan.index')
                ->with('success', 'Pengajuan pinjaman berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, PengajuanPinjaman $pengajuan)
    {
        if ($pengajuan->status !== 'Pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $pengajuan->update([
            'status' => 'Ditolak',
            'approved_by' => auth()->id(),
            'tanggal_diproses' => now(),
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()->route('admin-sp.pengajuan.index')
            ->with('success', 'Pengajuan pinjaman berhasil ditolak.');
    }
}
