@extends('layouts.app')

@section('title', 'Detail Pinjaman')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Pinjaman #{{ $pinjaman->id }}</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-sp.pinjaman.index') }}" class="hover-text-primary">Pinjaman</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-4">
            <!-- User Info Card -->
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-column text-center">
                        <img src="{{ asset('assets/images/users/user1.png') }}" alt="" class="w-120-px h-120-px rounded-circle object-fit-cover mb-24 text-center">
                        <h6 class="mb-0 fw-semibold">{{ $pinjaman->anggota->user->name }}</h6>
                        <span class="text-sm text-secondary-light">{{ $pinjaman->anggota->nomor_anggota }}</span>
                        <div class="mt-24 w-100">
                            <h6 class="text-lg fw-semibold text-primary-600 mb-0">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</h6>
                            <span class="text-secondary-light text-sm">Pokok Pinjaman</span>
                        </div>

                        <!-- Contact Info -->
                        <div class="mt-24 w-100 border-top pt-24 d-flex justify-content-center gap-3">
                            <a href="mailto:{{ $pinjaman->anggota->user->email }}" class="text-secondary-light hover-text-primary d-flex align-items-center gap-1" data-bs-toggle="tooltip" title="{{ $pinjaman->anggota->user->email }}">
                                <iconify-icon icon="mdi:email-outline" class="text-xl"></iconify-icon>
                            </a>
                            @if($pinjaman->anggota->nomor_wa)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pinjaman->anggota->nomor_wa)) }}" target="_blank" class="text-success-600 hover-text-success-700 d-flex align-items-center gap-1" data-bs-toggle="tooltip" title="{{ $pinjaman->anggota->nomor_wa }}">
                                <iconify-icon icon="logos:whatsapp-icon" class="text-xl"></iconify-icon>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush mt-24">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="text-secondary-light">Status</span>
                            <span class="badge {{ $pinjaman->status == 'Aktif' ? 'bg-success-focus text-success-main' : 'bg-info-focus text-info-main' }} px-12 py-6 rounded-pill">
                                {{ $pinjaman->status }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="text-secondary-light">Tanggal Pinjam</span>
                            <span class="fw-medium text-primary-light">{{ $pinjaman->tanggal_pinjaman->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="text-secondary-light">Jatuh Tempo</span>
                            <span class="fw-medium text-danger-main">{{ $pinjaman->tanggal_jatuh_tempo->format('d M Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Loan Details Card -->
            <div class="card mb-24">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Rincian Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-48-px h-48-px rounded-circle bg-primary-100 d-flex justify-content-center align-items-center text-primary-600 text-2xl">
                                    <iconify-icon icon="mdi:calendar-month-outline"></iconify-icon>
                                </div>
                                <div>
                                    <span class="text-secondary-light text-sm">Tenor</span>
                                    <h6 class="mb-0 fw-semibold">{{ $pinjaman->tenor }} Bulan</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-48-px h-48-px rounded-circle bg-warning-100 d-flex justify-content-center align-items-center text-warning-600 text-2xl">
                                    <iconify-icon icon="mdi:percent-outline"></iconify-icon>
                                </div>
                                <div>
                                    <span class="text-secondary-light text-sm">Bunga</span>
                                    <h6 class="mb-0 fw-semibold">{{ number_format($pinjaman->bunga, 2) }}%</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-48-px h-48-px rounded-circle bg-success-100 d-flex justify-content-center align-items-center text-success-600 text-2xl">
                                    <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
                                </div>
                                <div>
                                    <span class="text-secondary-light text-sm">Angsuran Bulanan</span>
                                    <h6 class="mb-0 fw-semibold">Rp {{ number_format($pinjaman->angsuran_bulanan, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-48-px h-48-px rounded-circle bg-info-100 d-flex justify-content-center align-items-center text-info-600 text-2xl">
                                    <iconify-icon icon="mdi:bank-transfer"></iconify-icon>
                                </div>
                                <div>
                                    <span class="text-secondary-light text-sm">Total Pinjaman (+Bunga)</span>
                                    <h6 class="mb-0 fw-semibold">Rp {{ number_format($pinjaman->total_pinjaman, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-32">
                        @php
                            $totalRepayable = $pinjaman->total_pinjaman;
                            $remaining = $pinjaman->sisa_pinjaman;
                            $paidAmount = $totalRepayable - $remaining;
                            
                            $progress = ($totalRepayable > 0) ? ($paidAmount / $totalRepayable) * 100 : 0;
                        @endphp
                        
                        <div class="d-flex justify-content-between align-items-center mb-8">
                            <span class="text-secondary-light text-sm fw-medium">Progress Pembayaran</span>
                            <span class="text-primary-600 fw-bold">{{ number_format($progress, 1) }}%</span>
                        </div>
                        <div class="progress w-100 bg-primary-100 h-12-px rounded-pill">
                            <div class="progress-bar bg-primary-600 rounded-pill" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-8">
                             <small class="text-secondary-light">Terbayar: <span class="text-success-main fw-semibold">Rp {{ number_format($paidAmount, 0, ',', '.') }}</span></small>
                             <small class="text-secondary-light">Sisa: <span class="text-danger-main fw-semibold">Rp {{ number_format($remaining, 0, ',', '.') }}</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History Card -->
            <div class="card">
                <div class="card-header border-bottom bg-base py-16 px-24">
                     <h6 class="text-lg fw-semibold mb-0">Riwayat Pembayaran</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table basic-table mb-0">
                            <thead>
                                <tr>
                                    <th class="px-24">Ke</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Denda</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pinjaman->angsuran as $angsuran)
                                <tr>
                                    <td class="px-24">
                                        <span class="w-32-px h-32-px rounded-circle d-flex justify-content-center align-items-center bg-base text-secondary-light fw-medium">
                                            {{ $angsuran->angsuran_ke }}
                                        </span>
                                    </td>
                                    <td>{{ $angsuran->tanggal_bayar->format('d M Y') }}</td>
                                    <td class="text-success-main fw-medium">Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="text-danger-main">
                                        {{ $angsuran->denda > 0 ? 'Rp ' . number_format($angsuran->denda, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-secondary-light">{{ $angsuran->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-24 text-secondary-light">Belum ada riwayat pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
