<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    public function index()
    {
        // Get all anggota for DataTable (client-side pagination)
        $anggota = Anggota::with('user')->get();
        return view('superadmin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        $lastAnggota = Anggota::orderBy('nomor_urut', 'desc')->first();
        $nextNomorUrut = $lastAnggota ? $lastAnggota->nomor_urut + 1 : 1;
        
        return view('superadmin.anggota.create', compact('nextNomorUrut'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'nomor_urut' => 'required|integer|min:1',
            'tanggal_gabung' => 'required|date',
            'kode_sp' => 'required|string|max:10',
            'status_pegawai' => 'required|in:PNS,P3K,PPNPN',
            'status_keanggotaan' => 'required|in:Aktif,Tidak Aktif',
            'limit_pinjaman' => 'required|numeric|min:0',
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('anggota');

            // Generate nomor anggota
            $nomorAnggota = Anggota::generateNomorAnggota(
                $validated['nomor_urut'],
                $validated['tanggal_gabung'],
                $validated['kode_sp']
            );

            // Create anggota record
            $anggota = Anggota::create([
                'user_id' => $user->id,
                'nomor_anggota' => $nomorAnggota,
                'nomor_urut' => $validated['nomor_urut'],
                'tanggal_gabung' => $validated['tanggal_gabung'],
                'kode_sp' => $validated['kode_sp'],
                'status_pegawai' => $validated['status_pegawai'],
                'status_keanggotaan' => $validated['status_keanggotaan'],
                'limit_pinjaman' => $validated['limit_pinjaman'],
                'simpanan_pokok' => $validated['simpanan_pokok'],
                'simpanan_wajib' => $validated['simpanan_wajib'],
                'jumlah_belanja_minimarket' => 0,
            ]);

            // Create tabungan
            Tabungan::create([
                'anggota_id' => $anggota->id,
                'saldo' => 0,
            ]);

            DB::commit();

            return redirect()->route('superadmin.anggota.index')
                ->with('success', 'Anggota berhasil ditambahkan. Nomor Anggota: ' . $nomorAnggota);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Anggota $anggotum)
    {
        $anggotum->load(['user', 'simpananPokok', 'simpananWajib', 'pinjaman', 'tabungan', 'pengajuanPinjaman']);
        return view('superadmin.anggota.show', ['anggota' => $anggotum]);
    }

    public function edit(Anggota $anggotum)
    {
        $anggotum->load('user');
        return view('superadmin.anggota.edit', ['anggota' => $anggotum]);
    }

    public function update(Request $request, Anggota $anggotum)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $anggotum->user_id,
            'status_pegawai' => 'required|in:PNS,P3K,PPNPN',
            'status_keanggotaan' => 'required|in:Aktif,Tidak Aktif',
            'limit_pinjaman' => 'required|numeric|min:0',
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $anggotum->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $anggotum->update([
                'status_pegawai' => $validated['status_pegawai'],
                'status_keanggotaan' => $validated['status_keanggotaan'],
                'limit_pinjaman' => $validated['limit_pinjaman'],
                'simpanan_pokok' => $validated['simpanan_pokok'],
                'simpanan_wajib' => $validated['simpanan_wajib'],
            ]);

            DB::commit();

            return redirect()->route('superadmin.anggota.index')
                ->with('success', 'Anggota berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Anggota $anggotum)
    {
        DB::beginTransaction();
        try {
            $user = $anggotum->user;
            $anggotum->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('superadmin.anggota.index')
                ->with('success', 'Anggota berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
