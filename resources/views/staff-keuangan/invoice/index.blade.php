@extends('layouts.app')

@section('title', 'Manajemen Invoice - Coming Soon')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Manajemen Invoice</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('staff-keuangan.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Invoice</li>
        </ul>
    </div>

    <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-5">
            <div class="mb-4">
                <iconify-icon icon="fluent:rocket-20-regular" class="text-primary-600" width="120" height="120"></iconify-icon>
            </div>
            <h2 class="fw-bold mb-3">Coming Soon!</h2>
            <p class="text-secondary-light mb-4" style="max-width: 500px;">
                Fitur Manajemen Invoice sedang dalam pengembangan. Kami sedang bekerja keras untuk menghadirkan pengalaman pengelolaan invoice terbaik untuk Anda.
            </p>
            <a href="{{ route('staff-keuangan.dashboard') }}" class="btn btn-primary-600 px-4 py-2">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
