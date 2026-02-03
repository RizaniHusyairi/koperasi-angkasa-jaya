@extends('layouts.app')

@section('title', 'Detail Anggota Koperasi')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Anggota Koperasi</h6>
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
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="row">
        <!-- Profile Card - Enhanced Design -->
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <!-- Profile Cover -->
                <div class="bg-gradient-primary position-relative" style="height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="position-absolute w-100 text-center" style="bottom: -50px;">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('assets/images/users/user1.png') }}" alt="{{ $anggota->user->name }}" 
                                class="w-100-px h-100-px rounded-circle border border-5 border-white shadow-lg" style="object-fit: cover;">
                            <span class="position-absolute bottom-0 end-0 w-24-px h-24-px bg-{{ $anggota->status_keanggotaan == 'Aktif' ? 'success' : 'danger' }}-main rounded-circle border border-2 border-white d-flex align-items-center justify-content-center">
                                <iconify-icon icon="{{ $anggota->status_keanggotaan == 'Aktif' ? 'mdi:check' : 'mdi:close' }}" class="text-white text-xs"></iconify-icon>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body pt-5 mt-4 text-center">
                    <h5 class="mb-1 fw-bold">{{ $anggota->user->name }}</h5>
                    
                    <!-- Contact Info -->
                    <!-- Contact Info -->
                    <div class="mt-4 px-3 mb-3 text-start">
                        <a href="mailto:{{ $anggota->user->email }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-3 border border-neutral-200 hover-border-primary-600 hover-bg-primary-50 transition-all mb-2 text-decoration-none">
                            <span class="w-40-px h-40-px rounded-circle bg-primary-50 text-primary-600 d-flex align-items-center justify-content-center text-xl flex-shrink-0">
                                <iconify-icon icon="mdi:email-outline"></iconify-icon>
                            </span>
                            <div class="overflow-hidden">
                                <span class="d-block text-xs text-secondary-light">Email Address</span>
                                <span class="d-block fw-medium text-primary-heading text-truncate">{{ $anggota->user->email }}</span>
                            </div>
                        </a>
                        
                        @if($anggota->nomor_wa)
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $anggota->nomor_wa)) }}" target="_blank" class="d-flex align-items-center gap-3 px-3 py-2 rounded-3 border border-neutral-200 hover-border-success-600 hover-bg-success-50 transition-all text-decoration-none">
                             <span class="w-40-px h-40-px rounded-circle bg-success-50 text-success-600 d-flex align-items-center justify-content-center text-xl flex-shrink-0">
                                <iconify-icon icon="logos:whatsapp-icon" class="text-lg"></iconify-icon>
                            </span>
                            <div>
                                <span class="d-block text-xs text-secondary-light">WhatsApp</span>
                                <span class="d-block fw-medium text-primary-heading">{{ $anggota->nomor_wa }}</span>
                            </div>
                        </a>
                        @endif
                    </div>
                    
                    <!-- Member ID Badge -->
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-primary-50 rounded-pill mb-3">
                        <iconify-icon icon="mdi:card-account-details" class="text-primary-600 text-xl"></iconify-icon>
                        <span class="fw-semibold text-primary-600">{{ $anggota->nomor_anggota }}</span>
                    </div>
                    
                    <!-- Status Pills -->
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="badge bg-{{ $anggota->status_keanggotaan == 'Aktif' ? 'success' : 'danger' }}-600 px-16 py-8 rounded-pill d-flex align-items-center gap-1">
                            <iconify-icon icon="mdi:account-check"></iconify-icon>
                            {{ $anggota->status_keanggotaan }}
                        </span>
                        <span class="badge bg-info-600 px-16 py-8 rounded-pill d-flex align-items-center gap-1">
                            <iconify-icon icon="mdi:briefcase"></iconify-icon>
                            {{ $anggota->status_pegawai }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informasi Keanggotaan - Enhanced Design -->
            <div class="card mt-3 overflow-hidden">
                <div class="card-header bg-gradient-end-1 border-0">
                    <div class="d-flex align-items-center gap-2">
                        <span class="w-40-px h-40-px bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center">
                            <iconify-icon icon="mdi:information-outline" class="text-white text-xl"></iconify-icon>
                        </span>
                        <h6 class="card-title mb-0 text-white">Informasi Keanggotaan</h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Member Since -->
                    <div class="px-20 py-16 border-bottom d-flex align-items-center justify-content-between hover-bg-neutral-50 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Tanggal bergabung menjadi anggota koperasi">
                        <div class="d-flex align-items-center gap-12">
                            <span class="w-40-px h-40-px bg-primary-50 text-primary-600 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                <iconify-icon icon="mdi:calendar-clock" class="text-xl"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-secondary-light text-sm d-block">Tanggal Gabung</span>
                                <span class="fw-semibold">{{ $anggota->tanggal_gabung->format('d F Y') }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            @php
                                $memberSince = $anggota->tanggal_gabung->diffForHumans(['parts' => 2]);
                            @endphp
                            <span class="badge bg-primary-50 text-primary-600 rounded-pill">{{ $memberSince }}</span>
                        </div>
                    </div>

                    <!-- Kode SP -->
                    <div class="px-20 py-16 border-bottom d-flex align-items-center justify-content-between hover-bg-neutral-50 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Kode Simpan Pinjam berdasarkan status pegawai">
                        <div class="d-flex align-items-center gap-12">
                            <span class="w-40-px h-40-px bg-info-50 text-info-600 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                <iconify-icon icon="mdi:identifier" class="text-xl"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-secondary-light text-sm d-block">Kode SP</span>
                                <span class="fw-semibold">{{ $anggota->kode_sp }}</span>
                            </div>
                        </div>
                        <span class="badge bg-info-50 text-info-600 rounded-pill">
                            @if($anggota->kode_sp == '1') PNS
                            @elseif($anggota->kode_sp == '2') P3K
                            @else PPNPN
                            @endif
                        </span>
                    </div>

                    <!-- Limit Pinjaman with Progress -->
                    @php
                        // Limit dihitung berdasarkan POKOK pinjaman aktif, bukan sisa hutang dengan bunga
                        $limitUsed = $anggota->total_pinjaman_aktif;
                        $limitTotal = $anggota->limit_pinjaman;
                        $limitPercent = $limitTotal > 0 ? ($limitUsed / $limitTotal) * 100 : 0;
                        $limitAvailable = $limitTotal - $limitUsed;
                    @endphp
                    <div class="px-20 py-16 border-bottom hover-bg-neutral-50 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Limit pinjaman maksimal yang dapat digunakan">
                        <div class="d-flex align-items-center gap-12 mb-12">
                            <span class="w-40-px h-40-px bg-warning-50 text-warning-600 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                <iconify-icon icon="mdi:credit-card-settings" class="text-xl"></iconify-icon>
                            </span>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block">Limit Pinjaman</span>
                                <span class="fw-bold text-lg">Rp {{ number_format($limitTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="ps-5 ms-3">
                            <div class="progress mb-8" style="height: 8px;">
                                <div class="progress-bar bg-{{ $limitPercent < 50 ? 'success' : ($limitPercent < 80 ? 'warning' : 'danger') }}-main rounded-pill" 
                                    role="progressbar" 
                                    style="width: {{ $limitPercent }}%;" 
                                    aria-valuenow="{{ $limitPercent }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between text-sm">
                                <span class="text-{{ $limitPercent < 50 ? 'success' : ($limitPercent < 80 ? 'warning' : 'danger') }}-main">
                                    Terpakai: Rp {{ number_format($limitUsed, 0, ',', '.') }} ({{ number_format($limitPercent, 1) }}%)
                                </span>
                                <span class="text-secondary-light">
                                    Tersedia: Rp {{ number_format($limitAvailable, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Urut -->
                    <div class="px-20 py-16 d-flex align-items-center justify-content-between hover-bg-neutral-50 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Nomor urut pendaftaran anggota">
                        <div class="d-flex align-items-center gap-12">
                            <span class="w-40-px h-40-px bg-success-50 text-success-600 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                <iconify-icon icon="mdi:numeric" class="text-xl"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-secondary-light text-sm d-block">Nomor Urut</span>
                                <span class="fw-semibold">{{ str_pad($anggota->nomor_urut, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                        <span class="badge bg-success-50 text-success-600 rounded-pill px-12">
                            #{{ $anggota->nomor_urut }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="col-lg-8">
            <div class="row gy-3">
                <div class="col-sm-6">
                    <div class="card bg-gradient-start-1 h-100 hover-scale-102 transition-all cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-56-px h-56-px bg-primary-600 text-white d-flex justify-content-center align-items-center rounded-circle shadow-sm">
                                    <iconify-icon icon="mdi:piggy-bank" class="icon text-2xl"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm d-flex align-items-center gap-1">
                                        <iconify-icon icon="mdi:information-outline" class="text-xs" data-bs-toggle="tooltip" title="Total simpanan pokok yang telah dibayarkan"></iconify-icon>
                                        Simpanan Pokok
                                    </span>
                                    <h4 class="mb-0 mt-1">Rp {{ number_format($anggota->total_simpanan_pokok, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg-gradient-start-2 h-100 hover-scale-102 transition-all cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-56-px h-56-px bg-success-main text-white d-flex justify-content-center align-items-center rounded-circle shadow-sm">
                                    <iconify-icon icon="mdi:cash-multiple" class="icon text-2xl"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm d-flex align-items-center gap-1">
                                        <iconify-icon icon="mdi:information-outline" class="text-xs" data-bs-toggle="tooltip" title="Total simpanan wajib bulanan"></iconify-icon>
                                        Simpanan Wajib
                                    </span>
                                    <h4 class="mb-0 mt-1">Rp {{ number_format($anggota->total_simpanan_wajib, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg-gradient-start-4 h-100 hover-scale-102 transition-all cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-56-px h-56-px bg-warning-main text-white d-flex justify-content-center align-items-center rounded-circle shadow-sm">
                                    <iconify-icon icon="mdi:hand-coin" class="icon text-2xl"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm d-flex align-items-center gap-1">
                                        <iconify-icon icon="mdi:information-outline" class="text-xs" data-bs-toggle="tooltip" title="Total sisa pinjaman yang harus dilunasi"></iconify-icon>
                                        Sisa Pinjaman
                                    </span>
                                    <h4 class="mb-0 mt-1">Rp {{ number_format($anggota->total_sisa_pinjaman, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg-gradient-start-3 h-100 hover-scale-102 transition-all cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-56-px h-56-px bg-info-main text-white d-flex justify-content-center align-items-center rounded-circle shadow-sm">
                                    <iconify-icon icon="mdi:wallet" class="icon text-2xl"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm d-flex align-items-center gap-1">
                                        <iconify-icon icon="mdi:information-outline" class="text-xs" data-bs-toggle="tooltip" title="Saldo tabungan yang tersedia"></iconify-icon>
                                        Saldo Tabungan
                                    </span>
                                    <h4 class="mb-0 mt-1">Rp {{ number_format($anggota->tabungan->saldo ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pinjaman Aktif -->
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="w-40-px h-40-px bg-warning-50 text-warning-600 rounded-circle d-flex align-items-center justify-content-center">
                            <iconify-icon icon="mdi:format-list-bulleted" class="text-xl"></iconify-icon>
                        </span>
                        <h6 class="card-title mb-0">Pinjaman Aktif</h6>
                    </div>
                    <span class="badge bg-warning-600 rounded-pill">{{ $anggota->pinjaman->where('status', 'Aktif')->count() }} Pinjaman</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Pinjaman</th>
                                    <th>Sisa Pinjaman</th>
                                    <th>Progress</th>
                                    <th>Tenor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggota->pinjaman->where('status', 'Aktif') as $pinjaman)
                                @php
                                    // Calculate paid amount (handle case where sisa might be more due to interest)
                                    $totalWithInterest = $pinjaman->jumlah_pinjaman * (1 + ($pinjaman->bunga * $pinjaman->tenor / 100));
                                    $paidAmount = $totalWithInterest - $pinjaman->sisa_pinjaman;
                                    $paidPercent = $totalWithInterest > 0 ? max(0, min(100, ($paidAmount / $totalWithInterest) * 100)) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $pinjaman->tanggal_pinjaman->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</td>
                                    <td class="text-warning-main fw-semibold">Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</td>
                                    <td style="min-width: 160px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 8px; min-width: 80px;">
                                                <div class="progress-bar bg-{{ $paidPercent >= 75 ? 'success' : ($paidPercent >= 50 ? 'info' : ($paidPercent >= 25 ? 'warning' : 'primary')) }}-main rounded-pill" 
                                                    role="progressbar" 
                                                    style="width: {{ $paidPercent }}%;"
                                                    aria-valuenow="{{ $paidPercent }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="text-sm fw-medium" style="min-width: 40px;">{{ number_format($paidPercent, 0) }}%</span>
                                        </div>
                                        <small class="text-secondary-light">Terbayar: Rp {{ number_format(max(0, $paidAmount), 0, ',', '.') }}</small>
                                    </td>
                                    <td>{{ $pinjaman->tenor }} bulan</td>
                                    <td><span class="badge bg-success-600 rounded-pill px-12">{{ $pinjaman->status }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <iconify-icon icon="mdi:check-circle" class="text-success-main text-4xl"></iconify-icon>
                                            <span class="text-secondary-light">Tidak ada pinjaman aktif</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('superadmin.anggota.edit', $anggota) }}" class="btn btn-warning-600 d-flex align-items-center gap-1">
            <iconify-icon icon="mdi:pencil" class="icon"></iconify-icon>
            Edit Anggota
        </a>
        <a href="{{ route('superadmin.anggota.index') }}" class="btn btn-secondary d-flex align-items-center gap-1">
            <iconify-icon icon="mdi:arrow-left" class="icon"></iconify-icon>
            Kembali
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-scale-102:hover {
        transform: scale(1.02);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .hover-bg-neutral-50:hover {
        background-color: var(--neutral-50) !important;
    }
    .bg-gradient-end-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
