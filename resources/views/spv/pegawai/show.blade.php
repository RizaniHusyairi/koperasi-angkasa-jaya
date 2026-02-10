@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Pegawai</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('spv.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('spv.pegawai.index') }}" class="hover-text-primary">Pegawai</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Profile Section -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 position-relative d-inline-block">
                        <img src="{{ $pegawai->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($pegawai->nama_lengkap).'&background=random' }}" 
                             alt="{{ $pegawai->nama_lengkap }}" 
                             class="rounded-circle border border-3 border-white shadow-sm"
                             width="120" height="120"
                             style="object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white rounded-circle"></span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $pegawai->nama_lengkap }}</h5>
                    <p class="text-secondary-light mb-2">{{ $pegawai->jabatan }}</p>
                    <span class="badge bg-primary-50 text-primary-600 px-3 py-1 radius-4 fw-medium mb-3">
                        {{ $pegawai->unit_kerja }}
                    </span>
                    
                    <div class="d-flex flex-column gap-2 border-top pt-3 mt-2 text-start">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:email-outline" class="text-primary-600 text-lg"></iconify-icon>
                            <span class="text-secondary-light text-sm">{{ $pegawai->user->email ?? '-' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:phone-outline" class="text-primary-600 text-lg"></iconify-icon>
                            <span class="text-secondary-light text-sm">{{ $pegawai->telepon ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Informasi Lengkap</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('spv.pegawai.edit', $pegawai) }}" class="btn btn-warning-600 btn-sm d-flex align-items-center gap-1">
                            <iconify-icon icon="mdi:pencil" class="icon"></iconify-icon>
                            Edit
                        </a>
                        <a href="{{ route('spv.pegawai.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center gap-1">
                            <iconify-icon icon="mdi:arrow-left" class="icon"></iconify-icon>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <label class="form-label text-secondary-light mb-1">NIK</label>
                            <div class="fw-semibold text-primary-900">{{ $pegawai->nik }}</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-secondary-light mb-1">Status Akun</label>
                            <div>
                                @if($pegawai->user)
                                    <span class="badge bg-success-600">Aktif</span>
                                @else
                                    <span class="badge bg-danger-600">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-secondary-light mb-1">Unit Kerja</label>
                            <div class="fw-medium text-primary-900">{{ $pegawai->unit_kerja }}</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-secondary-light mb-1">Jabatan</label>
                            <div class="fw-medium text-primary-900">{{ $pegawai->jabatan }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary-light mb-1">Alamat</label>
                            <div class="fw-medium text-primary-900">{{ $pegawai->alamat ?? '-' }}</div>
                        </div>
                        
                        <div class="col-12">
                            <div class="alert alert-primary-50 text-primary-600 mb-0 d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:information-outline" class="text-xl"></iconify-icon>
                                <div>
                                    Pegawai ini terdaftar sebagai <strong>{{ $pegawai->user->roles->first()->name ?? 'Tanpa Role' }}</strong>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
