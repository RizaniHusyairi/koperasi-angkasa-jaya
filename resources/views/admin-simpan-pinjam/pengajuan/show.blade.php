@extends('layouts.app')

@section('title', 'Proses Pengajuan')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Proses Pengajuan</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-sp.pengajuan.index') }}" class="hover-text-primary">Pengajuan</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Proses</li>
        </ul>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Info Anggota -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Informasi Pemohon</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/users/user1.png') }}" class="w-80-px h-80-px rounded-circle mb-3" alt="User">
                    <h5 class="mb-1">{{ $pengajuan->anggota->user->name }}</h5>
                    <span class="badge bg-primary-600">{{ $pengajuan->anggota->nomor_anggota }}</span>
                    <div class="mt-2">
                        <span class="badge bg-{{ $pengajuan->anggota->status_keanggotaan == 'Aktif' ? 'success' : 'danger' }}-600">
                            {{ $pengajuan->anggota->status_keanggotaan }}
                        </span>
                        <span class="badge bg-info-600">{{ $pengajuan->anggota->status_pegawai }}</span>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Data Keuangan Anggota</h6>
                </div>
                <div class="card-body">
                    <table class="table basic-table mb-0">
                        <tr>
                            <td class="text-secondary-light">Limit Pinjaman</td>
                            <td class="text-end fw-medium">Rp {{ number_format($pengajuan->anggota->limit_pinjaman, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Pinjaman Aktif</td>
                            <td class="text-end fw-medium text-warning-main">Rp {{ number_format($pengajuan->anggota->total_sisa_pinjaman, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Sisa Limit</td>
                            <td class="text-end fw-semibold text-success-main">Rp {{ number_format($pengajuan->anggota->limit_pinjaman - $pengajuan->anggota->total_sisa_pinjaman, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Pengajuan -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="card-title mb-0">Detail Pengajuan</h6>
                        <span class="badge bg-{{ $pengajuan->status == 'Pending' ? 'warning' : ($pengajuan->status == 'Disetujui' ? 'success' : 'danger') }}-600 fs-6">
                            {{ $pengajuan->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table basic-table mb-0">
                        <tr>
                            <td class="text-secondary-light w-25">Tanggal Pengajuan</td>
                            <td class="fw-medium">{{ $pengajuan->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Jumlah Pengajuan</td>
                            <td class="fw-semibold text-primary-600 fs-5">Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Tenor</td>
                            <td class="fw-medium">{{ $pengajuan->tenor }} bulan</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <label class="form-label text-secondary-light">Keperluan</label>
                        <div class="p-3 bg-neutral-50 radius-8">
                            {{ $pengajuan->keperluan }}
                        </div>
                    </div>

                    @if($pengajuan->status == 'Pending')
                    <hr class="my-4">

                    <div class="row">
                        <!-- Approve Form -->
                        <div class="col-md-6">
                            <form action="{{ route('admin-sp.pengajuan.approve', $pengajuan) }}" method="POST">
                                @csrf
                                <h6 class="text-success-main mb-3 d-flex">
                                    <iconify-icon icon="mdi:check-circle" class="icon me-2"></iconify-icon>
                                    Setujui Pengajuan
                                </h6>
                                <div class="mb-3">
                                    <label for="bunga" class="form-label">Bunga (%)</label>
                                    <input type="number" class="form-control" id="bunga" name="bunga" step="0.01" min="0" max="100" value="1.5" required>
                                </div>
                                <div class="mb-3">
                                    <label for="catatan_approve" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control" id="catatan_approve" name="catatan_admin" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success-600 w-100" onclick="return confirm('Yakin ingin menyetujui pengajuan ini?')">
                                    <iconify-icon icon="mdi:check" class="icon me-1"></iconify-icon>
                                    Setujui
                                </button>
                            </form>
                        </div>

                        <!-- Reject Form -->
                        <div class="col-md-6">
                            <form action="{{ route('admin-sp.pengajuan.reject', $pengajuan) }}" method="POST">
                                @csrf
                                <h6 class="text-danger-main mb-3 d-flex">
                                    <iconify-icon icon="mdi:close-circle" class="icon me-2"></iconify-icon>
                                    Tolak Pengajuan
                                </h6>
                                <div class="mb-3">
                                    <label for="catatan_reject" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="catatan_reject" name="catatan_admin" rows="4" required placeholder="Masukkan alasan penolakan..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger-600 w-100" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                    <iconify-icon icon="mdi:close" class="icon me-1"></iconify-icon>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <hr class="my-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary-light">Tanggal Diproses</label>
                        <div class="fw-medium">{{ $pengajuan->tanggal_diproses?->format('d M Y H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary-light">Diproses Oleh</label>
                        <div class="fw-medium">{{ $pengajuan->approver?->name }}</div>
                    </div>
                    @if($pengajuan->catatan_admin)
                    <div class="mb-3">
                        <label class="form-label text-secondary-light">Catatan Admin</label>
                        <div class="p-3 bg-{{ $pengajuan->status == 'Disetujui' ? 'success' : 'danger' }}-50 radius-8">
                            {{ $pengajuan->catatan_admin }}
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin-sp.pengajuan.index') }}" class="btn btn-secondary" style="display: inline-flex;">
            <iconify-icon icon="mdi:arrow-left" class="icon me-1"></iconify-icon>
            Kembali
        </a>
    </div>
</div>
@endsection
