@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Mini Market')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Riwayat Pesanan</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('anggota.mini-market.index') }}" class="hover-text-primary">Mini Market</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Riwayat</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
            <h6 class="text-lg fw-semibold mb-0">Daftar Pesanan Saya</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Invoice</th>
                            <th scope="col">Total</th>
                            <th scope="col">Metode Pembayaran</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="text-primary-600 fw-medium">
                                    {{ $order->code }}
                                </span>
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
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-24 text-secondary-light">Belum ada pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
