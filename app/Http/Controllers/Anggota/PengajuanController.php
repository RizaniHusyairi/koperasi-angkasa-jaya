<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPinjaman;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $anggota = auth()->user()->anggota;
        $pengajuan = $anggota->pengajuanPinjaman()->orderBy('created_at', 'desc')->paginate(10);

        return view('anggota.pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $anggota = auth()->user()->anggota;
        $limitPinjaman = $anggota->limit_pinjaman;
        $sisaPinjamanAktif = $anggota->total_sisa_pinjaman;
        $sisaLimit = $limitPinjaman - $sisaPinjamanAktif;

        return view('anggota.pengajuan.create', compact('anggota', 'limitPinjaman', 'sisaLimit'));
    }

    public function store(Request $request)
    {
        $anggota = auth()->user()->anggota;

        $validated = $request->validate([
            'jumlah_pengajuan' => 'required|numeric|min:100000',
            'tenor' => 'required|integer|min:1|max:60',
            'keperluan' => 'required|string|max:1000',
        ]);

        // Check against limit
        $sisaLimit = $anggota->limit_pinjaman - $anggota->total_sisa_pinjaman;
        if ($validated['jumlah_pengajuan'] > $sisaLimit) {
            return back()->with('error', 'Jumlah pengajuan melebihi sisa limit pinjaman Anda.')
                ->withInput();
        }

        // Check for pending pengajuan
        $hasPending = $anggota->pengajuanPinjaman()->pending()->exists();
        if ($hasPending) {
            return back()->with('error', 'Anda masih memiliki pengajuan yang sedang diproses.')
                ->withInput();
        }

        PengajuanPinjaman::create([
            'anggota_id' => $anggota->id,
            'jumlah_pengajuan' => $validated['jumlah_pengajuan'],
            'tenor' => $validated['tenor'],
            'keperluan' => $validated['keperluan'],
            'status' => 'Pending',
        ]);

        return redirect()->route('anggota.pengajuan.index')
            ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

    public function show(PengajuanPinjaman $pengajuan)
    {
        $anggota = auth()->user()->anggota;

        if ($pengajuan->anggota_id !== $anggota->id) {
            abort(403);
        }

        return view('anggota.pengajuan.show', compact('pengajuan'));
    }
}
