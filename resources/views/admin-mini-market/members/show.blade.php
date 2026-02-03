@extends('layouts.app')

@section('title', 'Riwayat Belanja - ' . $user->name)

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Anggota & Riwayat Belanja</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.anggota.index') }}" class="hover-text-primary">Anggota</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body p-24 text-center">
                    <div class="w-100-px h-100-px rounded-circle bg-primary-50 d-inline-flex align-items-center justify-content-center text-primary-600 mb-16 mx-auto">
                        <span class="text-3xl fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <h6 class="mb-2 fw-bold text-lg">{{ $user->name }}</h6>
                    <span class="text-secondary-light text-sm">{{ $user->email }}</span>
                    
                    <div class="mt-24 text-start">
                        <div class="d-flex justify-content-between py-12 border-bottom">
                            <span class="text-secondary-light">Nomor Anggota</span>
                            <span class="fw-medium">{{ $user->anggota->nomor_anggota ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-12 border-bottom">
                            <span class="text-secondary-light">Unit Kerja</span>
                            <span class="fw-medium">{{ $user->anggota->unit_kerja ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-12 border-bottom">
                            <span class="text-secondary-light">Total Pesanan</span>
                            <span class="fw-medium">{{ $user->orders->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-12">
                            <span class="text-secondary-light">Total Belanja</span>
                            <span class="fw-bold text-primary-600">Rp {{ number_format($user->orders->where('status', 'Completed')->sum('total_amount'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Riwayat Pesanan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin-mini-market.orders.show', $order) }}" class="text-primary-600 fw-medium">
                                            {{ $order->code }}
                                        </a>
                                    </td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>{{ $order->payment_method }}</td>
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
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin-mini-market.orders.show', $order) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mdi:eye"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-24 text-secondary-light">Belum ada riwayat pesanan</td>
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
