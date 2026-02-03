@extends('layouts.app')

@section('title', 'Simpanan Wajib')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Simpanan Wajib</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Simpanan Wajib</li>
        </ul>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-start-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-secondary-light">Total Simpanan Wajib</span>
                            <h3 class="mb-0 mt-2">Rp {{ number_format($totalSimpananWajib, 0, ',', '.') }}</h3>
                        </div>
                        <span class="w-64-px h-64-px bg-success-main text-white d-flex justify-content-center align-items-center rounded-circle">
                            <iconify-icon icon="mdi:cash-multiple" class="icon text-2xl"></iconify-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">Riwayat Simpanan Wajib</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bulan</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($simpananWajib as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($simpananWajib->currentPage() - 1) * $simpananWajib->perPage() }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->bulan)->format('F Y') }}</td>
                            <td>{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="text-success-main">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data simpanan wajib</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $simpananWajib->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
