@extends('layouts.app')

@section('title', 'Dashboard Mini Market')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard Mini Market</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Overview</li>
        </ul>
    </div>

    <div class="row gy-4">
        <!-- Stats Cards -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card h-100 bg-gradient-start-1">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <div>
                            <span class="text-secondary-light text-sm">Pesanan Pending</span>
                            <h6 class="text-primary-light mb-0 mt-1">{{ $pendingOrders }}</h6>
                        </div>
                        <span class="w-48-px h-48-px bg-primary-600 text-white rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:clock-outline" class="text-2xl"></iconify-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6">
            <div class="card h-100 bg-gradient-start-2">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <div>
                            <span class="text-secondary-light text-sm">Penjualan Hari Ini</span>
                            <h6 class="text-primary-light mb-0 mt-1">Rp {{ number_format($salesToday, 0, ',', '.') }}</h6>
                        </div>
                        <span class="w-48-px h-48-px bg-success-600 text-white rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:cash-register" class="text-2xl"></iconify-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6">
            <div class="card h-100 bg-gradient-start-3">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <div>
                            <span class="text-secondary-light text-sm">Stok Menipis</span>
                            <h6 class="text-primary-light mb-0 mt-1">{{ $lowStockProducts }} Produk</h6>
                        </div>
                        <span class="w-48-px h-48-px bg-warning-600 text-white rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:alert-box-outline" class="text-2xl"></iconify-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                    <h6 class="text-lg fw-semibold mb-0">Pesanan Terbaru</h6>
                    <a href="{{ route('admin-mini-market.orders.index') }}" class="text-primary-600 hover-text-primary-800 fw-medium text-sm">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table basic-table mb-0">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Anggota</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin-mini-market.orders.show', $order) }}" class="text-primary-600 fw-medium">
                                            {{ $order->code }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="text-md mb-0 fw-medium">{{ $order->user->name }}</h6>
                                                <span class="text-sm text-secondary-light">{{ $order->user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $order->payment_method == 'Limit' ? 'bg-primary-50 text-primary-600' : 'bg-success-50 text-success-600' }} rounded-pill px-12">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'Pending' => 'bg-warning-50 text-warning-600',
                                                'Processing' => 'bg-info-50 text-info-600',
                                                'Completed' => 'bg-success-50 text-success-600',
                                                'Cancelled' => 'bg-danger-50 text-danger-600',
                                                default => 'bg-secondary-50 text-secondary-600',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-12">{{ $order->status }}</span>
                                    </td>
                                    <td>{{ $order->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin-mini-market.orders.show', $order) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mdi:eye"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-24 text-secondary-light">Belum ada pesanan terbaru</td>
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
