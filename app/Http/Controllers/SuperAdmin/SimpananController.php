<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\SimpananPokok;
use App\Models\SimpananWajib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function storePokok(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $simpananPokok = new SimpananPokok();
            $simpananPokok->anggota_id = $anggota->id;
            $simpananPokok->jumlah = $validated['jumlah'];
            $simpananPokok->tanggal = now();
            $simpananPokok->keterangan = 'Setoran Simpanan Pokok';
            $simpananPokok->save();

            // Update total simpanan pokok in anggota table
            $anggota->simpanan_pokok += $validated['jumlah'];
            $anggota->save();

            DB::commit();

            return redirect()->back()->with('success', 'Simpanan Pokok berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeWajib(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'bulan' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $simpananWajib = new SimpananWajib();
            $simpananWajib->anggota_id = $anggota->id;
            $simpananWajib->jumlah = $validated['jumlah'];
            $simpananWajib->tanggal = now();
            $simpananWajib->bulan = $validated['bulan'];
            $simpananWajib->keterangan = 'Setoran Simpanan Wajib';
            $simpananWajib->save();

            // Update total simpanan wajib in anggota table
            $anggota->simpanan_wajib += $validated['jumlah'];
            $anggota->save();

            DB::commit();

            return redirect()->back()->with('success', 'Simpanan Wajib berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function updatePokok(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Find existing simpanan pokok record (assuming single record or taking latest)
            $simpananPokok = SimpananPokok::where('anggota_id', $anggota->id)->latest()->first();

            if (!$simpananPokok) {
                // If no record exists but user wants to "edit" (maybe only total was migrated), create one
                $simpananPokok = new SimpananPokok();
                $simpananPokok->anggota_id = $anggota->id;
                $simpananPokok->tanggal = now();
                $simpananPokok->keterangan = 'Setoran Simpanan Pokok (Koreksi)';
                $oldAmount = 0;
            } else {
                $oldAmount = $simpananPokok->jumlah;
                $simpananPokok->keterangan = 'Setoran Simpanan Pokok (Diedit)';
            }

            $simpananPokok->jumlah = $validated['jumlah'];
            $simpananPokok->save();

            // Update total simpanan pokok in anggota table
            // We recalculate by removing old amount and adding new amount to ensure accuracy
            $anggota->simpanan_pokok = ($anggota->simpanan_pokok - $oldAmount) + $validated['jumlah'];
            $anggota->save();

            DB::commit();

            return redirect()->back()->with('success', 'Simpanan Pokok berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
