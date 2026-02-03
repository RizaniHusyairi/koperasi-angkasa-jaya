@extends('layouts.app')

@section('title', 'Tabungan')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Tabungan</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Tabungan</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card bg-gradient-start-3">
                <div class="card-body text-center py-5">
                    <span class="w-80-px h-80-px bg-info-main text-white d-flex justify-content-center align-items-center rounded-circle mx-auto mb-4">
                        <iconify-icon icon="mdi:wallet" class="icon text-3xl"></iconify-icon>
                    </span>
                    <span class="text-secondary-light">Saldo Tabungan Anda</span>
                    <h2 class="mb-0 mt-2">Rp {{ number_format($tabungan->saldo ?? 0, 0, ',', '.') }}</h2>
                    <p class="text-secondary-light mt-3 mb-0">
                        <small>Terakhir diperbarui: {{ $tabungan->updated_at?->format('d M Y H:i') ?? '-' }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
