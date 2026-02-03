@extends('layouts.app')

@section('title', 'Dashboard Admin Simpan Pinjam')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Admin Simpan Pinjam</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Total Anggota Aktif Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:account-group" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Anggota Aktif</span>
                                <h6 class="fw-semibold">{{ number_format($totalAnggota) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Pending Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-warning-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:file-clock" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Pengajuan Pending</span>
                                <h6 class="fw-semibold">{{ number_format($totalPengajuanPending) }}</h6>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin-sp.pengajuan.index') }}?status=Pending" class="text-warning-main fw-medium text-sm">Lihat Pengajuan →</a>
                </div>
            </div>
        </div>

        <!-- Total Pinjaman Aktif Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:hand-coin" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Pinjaman Aktif</span>
                                <h6 class="fw-semibold">{{ number_format($totalPinjamanAktif) }}</h6>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin-sp.pinjaman.index') }}?status=Aktif" class="text-success-main fw-medium text-sm">Lihat Pinjaman →</a>
                </div>
            </div>
        </div>

        <!-- Total Nilai Pinjaman Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-info-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:cash" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Total Nilai Pinjaman</span>
                                <h6 class="fw-semibold">Rp {{ number_format($totalNilaiPinjamanAktif, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row gy-4 mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Akses Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('admin-sp.pengajuan.index') }}?status=Pending" class="btn btn-warning-600 w-100 py-16">
                                <iconify-icon icon="mdi:file-document-check" class="icon me-2"></iconify-icon>
                                Proses Pengajuan
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin-sp.pinjaman.index') }}" class="btn btn-info-600 w-100 py-16">
                                <iconify-icon icon="mdi:format-list-bulleted" class="icon me-2"></iconify-icon>
                                Data Pinjaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
