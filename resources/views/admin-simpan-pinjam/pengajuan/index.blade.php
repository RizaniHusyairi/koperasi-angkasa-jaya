@extends('layouts.app')

@section('title', 'Pengajuan Pinjaman')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Pengajuan Pinjaman</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Pengajuan</li>
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
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h6 class="card-title mb-0">Daftar Pengajuan</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin-sp.pengajuan.index') }}?status=all" class="btn btn-sm {{ $status == 'all' ? 'btn-primary-600' : 'btn-outline-primary-600' }}">Semua</a>
                    <a href="{{ route('admin-sp.pengajuan.index') }}?status=Pending" class="btn btn-sm {{ $status == 'Pending' ? 'btn-warning-600' : 'btn-outline-warning-600' }}">Pending</a>
                    <a href="{{ route('admin-sp.pengajuan.index') }}?status=Disetujui" class="btn btn-sm {{ $status == 'Disetujui' ? 'btn-success-600' : 'btn-outline-success-600' }}">Disetujui</a>
                    <a href="{{ route('admin-sp.pengajuan.index') }}?status=Ditolak" class="btn btn-sm {{ $status == 'Ditolak' ? 'btn-danger-600' : 'btn-outline-danger-600' }}">Ditolak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Anggota</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <div>{{ $item->anggota->user->name }}</div>
                                <small class="text-secondary-light">{{ $item->anggota->nomor_anggota }}</small>
                            </td>
                            <td>Rp {{ number_format($item->jumlah_pengajuan, 0, ',', '.') }}</td>
                            <td>{{ $item->tenor }} bulan</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : ($item->status == 'Disetujui' ? 'success' : 'danger') }}-600">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin-sp.pengajuan.show', $item) }}" class="btn btn-sm btn-info-600">
                                    <iconify-icon icon="mdi:eye" class="icon"></iconify-icon>
                                    Proses
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada pengajuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $pengajuan->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
