@extends('layouts.app')

@section('title', 'Dashboard Anggota')

@section('content')
<div class="dashboard-main-body">
    <!-- Welcome Banner with Profile -->
    <div class="card border-0 shadow-sm mb-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
        <!-- Abstract Background -->
        <div class="position-absolute top-0 end-0 h-100 w-50 d-none d-md-block" style="background: linear-gradient(to left, rgba(255,255,255,0.2), transparent); clip-path: polygon(20% 0%, 100% 0, 100% 100%, 0% 100%);"></div>
        <div class="card-body p-4 position-relative z-1">
            <div class="d-flex align-items-center gap-4">
                <div class="position-relative">
                    <img src="{{ asset('assets/images/users/user1.png') }}" alt="{{ auth()->user()->name }}" class="w-80-px h-80-px rounded-circle border border-2 border-white shadow-sm">
                    <span class="position-absolute bottom-0 end-0 w-20-px h-20-px bg-{{ $anggota->status_keanggotaan == 'Aktif' ? 'success' : 'danger' }}-main rounded-circle border border-2 border-white"></span>
                </div>
                <div>
                    <h4 class="text-white mb-1 fw-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
                    <p class="text-white text-opacity-75 mb-2">Anggota Koperasi Angkasa Jaya</p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-opacity-20 border border-white border-opacity-25 rounded-pill">{{ $anggota->nomor_anggota }}</span>
                        <span class="badge bg-opacity-20 border border-white border-opacity-25 rounded-pill">{{ $anggota->status_pegawai }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row gy-4 mb-4">
        <!-- Simpanan Pokok -->
        <div class="col-xxl-3 col-sm-6 my-5">
            <div class="card p-3 h-100 shadow-sm hover-scale-105 transition-all cursor-pointer border">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="w-56-px h-56-px bg-primary-50 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-primary-600 shadow-sm">
                            <iconify-icon icon="mdi:piggy-bank" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <span class="text-neutral-500 fw-medium text-sm">Simpanan Pokok</span>
                            <h5 class="mb-0 fw-bold text-neutral-900">Rp {{ number_format($totalSimpananPokok, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-neutral-100 d-flex justify-content-between align-items-center">
                        <span class="text-xs text-neutral-500">Akumulasi Simpanan</span>
                        <a href="{{ route('anggota.simpanan.pokok') }}" class="text-primary-600 text-sm fw-semibold hover-text-primary-700">Lihat Detail &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simpanan Wajib -->
        <div class="col-xxl-3 col-sm-6 my-5">
            <div class="card p-3 h-100 shadow-sm hover-scale-105 transition-all cursor-pointer border">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="w-56-px h-56-px bg-success-50 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-success-600 shadow-sm">
                            <iconify-icon icon="mdi:cash-multiple" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <span class="text-neutral-500 fw-medium text-sm">Simpanan Wajib</span>
                            <h5 class="mb-0 fw-bold text-neutral-900">Rp {{ number_format($totalSimpananWajib, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-neutral-100 d-flex justify-content-between align-items-center">
                        <span class="text-xs text-neutral-500">Rutin Bulanan</span>
                        <a href="{{ route('anggota.simpanan.wajib') }}" class="text-success-main text-sm fw-semibold hover-text-success-800">Lihat Detail &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sisa Pinjaman -->
        <div class="col-xxl-3 col-sm-6 my-5">
            <div class="card p-3 h-100 shadow-sm hover-scale-105 transition-all cursor-pointer border">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="w-56-px h-56-px bg-warning-50 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-warning-600 shadow-sm">
                            <iconify-icon icon="mdi:hand-coin" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <span class="text-neutral-500 fw-medium text-sm">Sisa Pinjaman</span>
                            <h5 class="mb-0 fw-bold text-neutral-900">Rp {{ number_format($totalSisaPinjaman, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-neutral-100 d-flex justify-content-between align-items-center">
                        <span class="text-xs text-neutral-500">Kewajiban Aktif</span>
                        <a href="{{ route('anggota.pinjaman.index') }}" class="text-warning-main text-sm fw-semibold hover-text-warning-800">Lihat Detail &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Saldo Tabungan -->
        <div class="col-xxl-3 col-sm-6 my-5">
            <div class="card p-3 h-100 shadow-sm hover-scale-105 transition-all cursor-pointer border">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="w-56-px h-56-px bg-info-50 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-info-600 shadow-sm">
                            <iconify-icon icon="mdi:wallet" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <span class="text-neutral-500 fw-medium text-sm">Saldo Tabungan</span>
                            <h5 class="mb-0 fw-bold text-neutral-900">Rp {{ number_format($saldoTabungan, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-neutral-100 d-flex justify-content-between align-items-center">
                        <span class="text-xs text-neutral-500">Simpanan Sukarela</span>
                        <a href="{{ route('anggota.tabungan.index') }}" class="text-info-main text-sm fw-semibold hover-text-info-800">Lihat Detail &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <!-- Main Content: Transaction History (Left Transposed to maximize width for table) -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0 radius-12 p-3">
                <div class="card-header border-bottom bg-transparent py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="w-32-px h-32-px bg-primary-50 rounded-circle d-flex align-items-center justify-content-center">
                            <iconify-icon icon="mdi:cart-outline" class="text-primary-600 text-lg"></iconify-icon>
                        </div>
                        <h6 class="fw-bold mb-0 text-neutral-900">Riwayat Belanja</h6>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table basic-table mb-0 p-2">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-4">Order ID</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestOrders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-semibold">#{{ $order->code }}</span>
                                    </td>
                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                        <span class="d-block text-xs text-secondary-light">{{ $order->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-1 bg-{{ $order->status == 'Completed' ? 'success' : ($order->status == 'Pending' ? 'warning' : 'danger') }}-50 text-{{ $order->status == 'Completed' ? 'success' : ($order->status == 'Pending' ? 'warning' : 'danger') }}-600 fw-medium">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="#" class="btn btn-sm btn-icon btn-light text-primary-600 rounded-circle hover-bg-primary-50 transition-all" data-bs-toggle="tooltip" title="Lihat Detail">
                                            <iconify-icon icon="solar:eye-linear" class="text-lg"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <div class="w-64-px h-64-px bg-neutral-50 rounded-circle d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="mdi:cart-off" class="text-neutral-400 text-3xl"></iconify-icon>
                                            </div>
                                            <div class="text-center">
                                                <h6 class="text-neutral-500 fw-semibold mb-1">Belum ada transaksi</h6>
                                                <p class="text-neutral-500 text-sm mb-3">Mulai belanja kebutuhan pokok Anda sekarang.</p>
                                                <a href="{{ route('anggota.mini-market.index') }}" class="btn btn-primary-600 btn-sm rounded-pill px-4">
                                                    <iconify-icon icon="mdi:cart-plus" class="mx-auto text-center"></iconify-icon>
                                                    <span>Mulai Belanja</span>
                                                </a>
                                            </div>
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

        <!-- Right Side: Limit & Actions -->
        <div class="col-lg-4">
            <!-- Limit Pinjaman Card -->
            <div class="card shadow-sm border-0 radius-12 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <iconify-icon icon="mdi:credit-card-chip-outline" class="text-9xl"></iconify-icon>
                </div>
                <div class="card-body position-relative z-1">
                    <h6 class="text-white mb-4 fw-medium border-bottom border-white border-opacity-25 pb-3">Informasi Limit Pinjaman</h6>
                    
                    <div class="mb-4">
                        <span class="text-white text-opacity-75 text-sm d-block mb-1">Total Limit Tersedia</span>
                        <h3 class="text-white fw-bold mb-0">Rp {{ number_format($anggota->limit_pinjaman - $totalSisaPinjaman, 0, ',', '.') }}</h3>
                        <span class="text-white text-opacity-75 text-xs">dari total Rp {{ number_format($anggota->limit_pinjaman, 0, ',', '.') }}</span>
                    </div>

                    @php
                        $usedPercent = $anggota->limit_pinjaman > 0 ? ($totalSisaPinjaman / $anggota->limit_pinjaman) * 100 : 0;
                    @endphp
                    
                    <div class="mb-2">
                        <div class="d-flex justify-content-between text-xs text-white text-opacity-75 mb-1">
                            <span>Terpakai</span>
                            <span>{{ number_format($usedPercent, 1) }}%</span>
                        </div>
                        <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-white rounded-pill shadow-sm" role="progressbar" style="width: {{ $usedPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 radius-12">
                <div class="card-header bg-transparent border-bottom px-4 py-3">
                    <h6 class="fw-bold mb-0 text-neutral-900">Aksi Cepat</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-3">
                        <a href="{{ route('anggota.pengajuan.create') }}" class="btn btn-primary-600 d-flex align-items-center justify-content-between p-3 rounded-3 hover-scale-102 transition-all">
                            <span class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:file-document-edit-outline" class="text-xl"></iconify-icon>
                                <span class="fw-semibold">Ajukan Pinjaman</span>
                            </span>
                            <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                        </a>
                        <a href="{{ route('anggota.simpanan.wajib') }}" class="btn btn-outline-success d-flex align-items-center justify-content-between p-3 rounded-3 hover-scale-102 transition-all">
                            <span class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:cash-fast" class="text-xl"></iconify-icon>
                                <span class="fw-semibold">Bayar Simpanan</span>
                            </span>
                            <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                        </a>
                        <a href="#" class="btn btn-outline-warning d-flex align-items-center justify-content-between p-3 rounded-3 hover-scale-102 transition-all">
                            <span class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:cart-outline" class="text-xl"></iconify-icon>
                                <span class="fw-semibold">Belanja Sekarang</span>
                            </span>
                            <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
