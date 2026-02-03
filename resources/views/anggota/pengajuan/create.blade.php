@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Ajukan Pinjaman</h6>
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
            <li class="fw-medium">Ajukan</li>
        </ul>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-gradient-start-3 mb-3">
                <div class="card-body">
                    <span class="text-secondary-light">Limit Pinjaman Anda</span>
                    <h4 class="mb-0 mt-2">Rp {{ number_format($limitPinjaman, 0, ',', '.') }}</h4>
                </div>
            </div>
            <div class="card bg-gradient-start-2">
                <div class="card-body">
                    <span class="text-secondary-light">Sisa Limit Tersedia</span>
                    <h4 class="mb-0 mt-2 text-success-main">Rp {{ number_format($sisaLimit, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Form Pengajuan Pinjaman</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('anggota.pengajuan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="jumlah_pengajuan" class="form-label">Jumlah Pinjaman <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('jumlah_pengajuan') is-invalid @enderror" id="jumlah_pengajuan" name="jumlah_pengajuan" value="{{ old('jumlah_pengajuan') }}" min="100000" max="{{ $sisaLimit }}" required>
                            </div>
                            @error('jumlah_pengajuan')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <small class="">Minimal Rp 100.000, Maksimal Rp {{ number_format($sisaLimit, 0, ',', '.') }}</small>
                        </div>

                        <div class="mb-3">
                            <label for="tenor" class="form-label">Tenor (Bulan) <span class="text-danger">*</span></label>
                            <select class="form-select @error('tenor') is-invalid @enderror" id="tenor" name="tenor" required>
                                <option value="">Pilih Tenor</option>
                                @foreach([6, 12, 18, 24, 36, 48, 60] as $t)
                                <option value="{{ $t }}" {{ old('tenor') == $t ? 'selected' : '' }}>{{ $t }} Bulan</option>
                                @endforeach
                            </select>
                            @error('tenor')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" rows="4" required placeholder="Jelaskan keperluan pinjaman Anda...">{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <iconify-icon icon="mdi:information" class="icon me-2"></iconify-icon>
                            Pengajuan akan diproses oleh Admin Simpan Pinjam. Anda akan mendapat notifikasi jika pengajuan telah diproses.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-600">
                                <iconify-icon icon="mdi:send" class="icon me-1"></iconify-icon>
                                Kirim Pengajuan
                            </button>
                            <a href="{{ route('anggota.pengajuan.index') }}" class="btn btn-secondary">
                                <iconify-icon icon="mdi:arrow-left" class="icon me-1"></iconify-icon>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
