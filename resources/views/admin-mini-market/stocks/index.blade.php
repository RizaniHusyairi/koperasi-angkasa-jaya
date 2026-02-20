@extends('layouts.app')

@section('title', 'Riwayat Stok - Mini Market')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Riwayat Stok</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Riwayat Stok</li>
        </ul>
    </div>

    <!-- Stats Cards -->
    <div class="row gy-4 mb-24">
        <div class="col-sm-4">
            <a href="{{ route('admin-mini-market.stocks.in.create') }}" class="card p-3 radius-8 bg-success-50 text-center hover-scale border-0">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <div class="w-48-px h-48-px rounded-circle bg-success text-white d-flex justify-content-center align-items-center text-2xl">
                        <iconify-icon icon="mdi:arrow-down-box"></iconify-icon>
                    </div>
                </div>
                <h6 class="text-md fw-semibold mb-1 text-success">Stok Masuk</h6>
                <span class="text-sm text-secondary-light">Tambah Barang</span>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('admin-mini-market.stocks.out.create') }}" class="card p-3 radius-8 bg-danger-50 text-center hover-scale border-0">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <div class="w-48-px h-48-px rounded-circle bg-danger text-white d-flex justify-content-center align-items-center text-2xl">
                        <iconify-icon icon="mdi:arrow-up-box"></iconify-icon>
                    </div>
                </div>
                <h6 class="text-md fw-semibold mb-1 text-danger">Stok Keluar</h6>
                <span class="text-sm text-secondary-light">Kurangi Barang</span>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('admin-mini-market.stocks.opname.create') }}" class="card p-3 radius-8 bg-warning-50 text-center hover-scale border-0">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <div class="w-48-px h-48-px rounded-circle bg-warning text-white d-flex justify-content-center align-items-center text-2xl">
                        <iconify-icon icon="mdi:sync"></iconify-icon>
                    </div>
                </div>
                <h6 class="text-md fw-semibold mb-1 text-warning">Stok Opname</h6>
                <span class="text-sm text-secondary-light">Penyesuaian Fisik</span>
            </a>
        </div>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <span class="text-md fw-medium text-secondary-light mb-0">Daftar Riwayat Pergerakan Stok</span>
            </div>
        </div>
        <div class="card-body p-24">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Waktu</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Stok Awal</th>
                            <th scope="col">Perubahan</th>
                            <th scope="col">Stok Akhir</th>
                            <th scope="col">Admin / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td>
                                <span class="text-md mb-0 fw-normal text-secondary-light">
                                    {{ $trx->created_at->format('d M Y H:i') }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($trx->product->image)
                                        <img src="{{ Storage::url($trx->product->image) }}" alt="{{ $trx->product->name }}" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 object-fit-cover">
                                    @else
                                        <div class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg fw-semibold">
                                            {{ substr($trx->product->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="text-md mb-0 fw-medium">{{ $trx->product->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($trx->type == 'in')
                                    <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Masuk</span>
                                @elseif($trx->type == 'out')
                                    <span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">Keluar</span>
                                @else
                                    <span class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Opname</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-md mb-0 fw-normal text-secondary-light">{{ $trx->previous_stock }}</span>
                            </td>
                            <td>
                                <span class="text-md mb-0 fw-semibold {{ $trx->type == 'in' ? 'text-success' : ($trx->type == 'out' ? 'text-danger' : ($trx->new_stock > $trx->previous_stock ? 'text-success' : 'text-danger')) }}">
                                    {{ ($trx->type == 'in' || ($trx->type == 'opname' && $trx->new_stock > $trx->previous_stock)) ? '+' : '-' }}{{ $trx->quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="text-md mb-0 fw-bold">{{ $trx->new_stock }}</span>
                            </td>
                            <td>
                                <div class="text-md fw-medium text-primary-light">{{ $trx->user->name ?? 'Sistem' }}</div>
                                <div class="text-sm text-secondary-light">{{ $trx->notes ?? '-' }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada riwayat stok</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                <span>Menampilkan {{ $transactions->firstItem() ?? 0 }} sampai {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} data</span>
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
.hover-scale { transition: transform 0.2s; }
.hover-scale:hover { transform: translateY(-5px); }
</style>
@endsection
