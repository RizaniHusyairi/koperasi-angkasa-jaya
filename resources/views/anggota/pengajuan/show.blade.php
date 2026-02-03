@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Pengajuan</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('anggota.pengajuan.index') }}" class="hover-text-primary">Pengajuan</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0">Informasi Pengajuan</h6>
                <span class="badge bg-{{ $pengajuan->status == 'Pending' ? 'warning' : ($pengajuan->status == 'Disetujui' ? 'success' : 'danger') }}-600 fs-6">
                    {{ $pengajuan->status }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-secondary-light w-50">Tanggal Pengajuan</td>
                            <td class="fw-medium">{{ $pengajuan->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Jumlah Pengajuan</td>
                            <td class="fw-semibold text-primary-600">Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Tenor</td>
                            <td class="fw-medium">{{ $pengajuan->tenor }} Bulan</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-secondary-light w-50">Tanggal Diproses</td>
                            <td class="fw-medium">{{ $pengajuan->tanggal_diproses?->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Diproses Oleh</td>
                            <td class="fw-medium">{{ $pengajuan->approver?->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label text-secondary-light">Keperluan</label>
                <div class="p-3 bg-neutral-50 radius-8">
                    {{ $pengajuan->keperluan }}
                </div>
            </div>

            @if($pengajuan->catatan_admin)
            <div class="mb-3">
                <label class="form-label text-secondary-light">Catatan Admin</label>
                <div class="p-3 bg-{{ $pengajuan->status == 'Disetujui' ? 'success' : 'danger' }}-50 radius-8">
                    {{ $pengajuan->catatan_admin }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('anggota.pengajuan.index') }}" class="btn btn-secondary">
            <iconify-icon icon="mdi:arrow-left" class="icon me-1"></iconify-icon>
            Kembali
        </a>
    </div>
</div>
@endsection
