@extends('layouts.app')

@section('title', 'Dashboard SPV')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('spv.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">SPV</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Total Pegawai Card -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:account-tie" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Total Pegawai</span>
                                <h6 class="fw-semibold">{{ number_format($totalPegawai) }}</h6>
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
                            <a href="{{ route('spv.pegawai.create') }}" class="btn btn-primary-600 w-100 py-16">
                                <iconify-icon icon="mdi:account-plus" class="icon me-2"></iconify-icon>
                                Tambah Pegawai
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('spv.pegawai.index') }}" class="btn btn-info-600 w-100 py-16">
                                <iconify-icon icon="mdi:format-list-bulleted" class="icon me-2"></iconify-icon>
                                Lihat Semua Pegawai
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
