<?php

namespace App\Http\Controllers\SPV;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::paginate(10);
        return view('spv.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('spv.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['staff-keuangan'])],
            'nik' => 'required|string|unique:pegawai,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        // Create User
        $user = User::create([
            'name' => $validated['nama_lengkap'], // Use nama_lengkap as name
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        // Create Pegawai
        Pegawai::create([
            'user_id' => $user->id,
            'nik' => $validated['nik'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'jabatan' => $validated['jabatan'],
            'unit_kerja' => $validated['unit_kerja'],
            'telepon' => $validated['telepon'],
            'alamat' => $validated['alamat'],
        ]);

        return redirect()->route('spv.pegawai.index')
            ->with('success', 'Pegawai dan akun pengguna berhasil ditambahkan.');
    }

    public function show(Pegawai $pegawai)
    {
        return view('spv.pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        return view('spv.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nik' => 'required|string|unique:pegawai,nik,' . $pegawai->id,
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        $pegawai->update($validated);

        return redirect()->route('spv.pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('spv.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
