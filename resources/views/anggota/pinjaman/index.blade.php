@extends('layouts.app')

@section('title', 'Sisa Pinjaman')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Sisa Pinjaman</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Sisa Pinjaman</li>
        </ul>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-start-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-secondary-light">Total Sisa Pinjaman</span>
                            <h3 class="mb-0 mt-2">Rp {{ number_format($totalSisaPinjaman, 0, ',', '.') }}</h3>
                        </div>
                        <span class="w-64-px h-64-px bg-warning-main text-white d-flex justify-content-center align-items-center rounded-circle">
                            <iconify-icon icon="mdi:hand-coin" class="icon text-2xl"></iconify-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">Data Pinjaman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Pinjaman</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Sisa Pinjaman</th>
                            <th>Tenor</th>
                            <th>Bunga</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjaman as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pinjaman->currentPage() - 1) * $pinjaman->perPage() }}</td>
                            <td>{{ $item->tanggal_pinjaman->format('d M Y') }}</td>
                            <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                            <td class="text-warning-main fw-semibold">Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}</td>
                            <td>{{ $item->tenor }} bulan</td>
                            <td>{{ number_format($item->bunga, 2) }}%</td>
                            <td>{{ $item->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : ($item->status == 'Lunas' ? 'primary' : 'danger') }}-600">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pinjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $pinjaman->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
