@extends('layouts.app')

@section('title', 'Pengajuan Pinjaman')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Pengajuan Pinjaman</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Pengajuan Pinjaman</li>
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">Riwayat Pengajuan</h6>
            <a href="{{ route('anggota.pengajuan.create') }}" class="btn btn-primary-600">
                <iconify-icon icon="mdi:plus" class="icon me-1"></iconify-icon>
                Ajukan Pinjaman
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($item->jumlah_pengajuan, 0, ',', '.') }}</td>
                            <td>{{ $item->tenor }} bulan</td>
                            <td>{{ Str::limit($item->keperluan, 30) }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : ($item->status == 'Disetujui' ? 'success' : 'danger') }}-600">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('anggota.pengajuan.show', $item) }}" class="btn btn-sm btn-info-600">
                                    <iconify-icon icon="mdi:eye" class="icon"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada pengajuan pinjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
