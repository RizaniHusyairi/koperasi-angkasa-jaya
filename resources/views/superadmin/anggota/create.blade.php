@extends('layouts.app')

@section('title', 'Tambah Anggota Koperasi')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Tambah Anggota Koperasi</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('superadmin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('superadmin.anggota.index') }}" class="hover-text-primary">Anggota</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Tambah</li>
        </ul>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">Form Tambah Anggota</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.anggota.store') }}" method="POST">
                @csrf
                
                <h6 class="mb-3 text-primary-600">Data Akun</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="mb-3 text-primary-600">Data Keanggotaan</h6>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="nomor_urut" class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nomor_urut') is-invalid @enderror" id="nomor_urut" name="nomor_urut" value="{{ old('nomor_urut', $nextNomorUrut) }}" min="1" required>
                        @error('nomor_urut')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="tanggal_gabung" class="form-label">Tanggal Gabung <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_gabung') is-invalid @enderror" id="tanggal_gabung" name="tanggal_gabung" value="{{ old('tanggal_gabung', date('Y-m-d')) }}" required>
                        @error('tanggal_gabung')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="kode_sp" class="form-label">Kode SP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_sp') is-invalid @enderror" id="kode_sp" name="kode_sp" value="{{ old('kode_sp', 'SP') }}" maxlength="10" required>
                        @error('kode_sp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="status_pegawai" class="form-label">Status Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pegawai') is-invalid @enderror" id="status_pegawai" name="status_pegawai" required>
                            <option value="PNS" {{ old('status_pegawai') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="P3K" {{ old('status_pegawai') == 'P3K' ? 'selected' : '' }}>P3K</option>
                            <option value="PPNPN" {{ old('status_pegawai') == 'PPNPN' ? 'selected' : '' }}>PPNPN</option>
                        </select>
                        @error('status_pegawai')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="status_keanggotaan" class="form-label">Status Keanggotaan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_keanggotaan') is-invalid @enderror" id="status_keanggotaan" name="status_keanggotaan" required>
                            <option value="Aktif" {{ old('status_keanggotaan', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status_keanggotaan') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status_keanggotaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="limit_pinjaman" class="form-label">Limit Pinjaman <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('limit_pinjaman') is-invalid @enderror" id="limit_pinjaman" name="limit_pinjaman" value="{{ old('limit_pinjaman', 50000000) }}" min="0" required>
                        @error('limit_pinjaman')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="simpanan_pokok" class="form-label">Simpanan Pokok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('simpanan_pokok') is-invalid @enderror" id="simpanan_pokok" name="simpanan_pokok" value="{{ old('simpanan_pokok', 100000) }}" min="0" required>
                        @error('simpanan_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="simpanan_wajib" class="form-label">Simpanan Wajib <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('simpanan_wajib') is-invalid @enderror" id="simpanan_wajib" name="simpanan_wajib" value="{{ old('simpanan_wajib', 50000) }}" min="0" required>
                        @error('simpanan_wajib')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <iconify-icon icon="mdi:information" class="icon me-2"></iconify-icon>
                    <strong>Format Nomor Anggota:</strong> {nomor_urut}{tahun}{bulan}{kode_sp} - Contoh: 001202601SP
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary-600">
                        <iconify-icon icon="mdi:content-save" class="icon me-1"></iconify-icon>
                        Simpan
                    </button>
                    <a href="{{ route('superadmin.anggota.index') }}" class="btn btn-secondary">
                        <iconify-icon icon="mdi:arrow-left" class="icon me-1"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
