@extends('layouts.app')

@section('title', 'Dashboard Staff Keuangan')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('staff-keuangan.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Staff Keuangan</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Pendapatan Card -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:finance" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Pendapatan</span>
                                <h6 class="fw-semibold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Card -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-warning-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:cash-minus" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Pengeluaran</span>
                                <h6 class="fw-semibold">Rp 0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Invoice Card -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-success-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:file-document-outline" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-sm">Status Invoice</span>
                                <h6 class="fw-semibold">0 Pending</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
