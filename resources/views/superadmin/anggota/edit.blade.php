@extends('layouts.app')

@section('title', 'Edit Anggota Koperasi')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Anggota Koperasi</h6>
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
            <li class="fw-medium">Edit</li>
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
            <h6 class="card-title mb-0">Form Edit Anggota - {{ $anggota->nomor_anggota }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.anggota.update', $anggota) }}" method="POST">
                @csrf
                @method('PUT')
                
                <h6 class="mb-3 text-primary-600">Data Akun</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $anggota->user->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $anggota->user->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="mb-3 text-primary-600">Data Keanggotaan</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nomor Anggota</label>
                        <input type="text" class="form-control" value="{{ $anggota->nomor_anggota }}" disabled>
                        <small class="text-muted">Nomor anggota tidak dapat diubah</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_pegawai" class="form-label">Status Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pegawai') is-invalid @enderror" id="status_pegawai" name="status_pegawai" required>
                            <option value="PNS" {{ old('status_pegawai', $anggota->status_pegawai) == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="P3K" {{ old('status_pegawai', $anggota->status_pegawai) == 'P3K' ? 'selected' : '' }}>P3K</option>
                            <option value="PPNPN" {{ old('status_pegawai', $anggota->status_pegawai) == 'PPNPN' ? 'selected' : '' }}>PPNPN</option>
                        </select>
                        @error('status_pegawai')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_keanggotaan" class="form-label">Status Keanggotaan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_keanggotaan') is-invalid @enderror" id="status_keanggotaan" name="status_keanggotaan" required>
                            <option value="Aktif" {{ old('status_keanggotaan', $anggota->status_keanggotaan) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status_keanggotaan', $anggota->status_keanggotaan) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status_keanggotaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="limit_pinjaman" class="form-label">Limit Pinjaman <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('limit_pinjaman') is-invalid @enderror" id="limit_pinjaman" name="limit_pinjaman" value="{{ old('limit_pinjaman', $anggota->limit_pinjaman) }}" min="0" required>
                        @error('limit_pinjaman')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="simpanan_pokok" class="form-label">Simpanan Pokok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('simpanan_pokok') is-invalid @enderror" id="simpanan_pokok" name="simpanan_pokok" value="{{ old('simpanan_pokok', $anggota->simpanan_pokok) }}" min="0" required>
                        @error('simpanan_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="simpanan_wajib" class="form-label">Simpanan Wajib <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('simpanan_wajib') is-invalid @enderror" id="simpanan_wajib" name="simpanan_wajib" value="{{ old('simpanan_wajib', $anggota->simpanan_wajib) }}" min="0" required>
                        @error('simpanan_wajib')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary-600">
                        <iconify-icon icon="mdi:content-save" class="icon me-1"></iconify-icon>
                        Perbarui
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
