@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Pegawai</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('spv.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('spv.pegawai.index') }}" class="hover-text-primary">Pegawai</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">Informasi Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-secondary-light w-50">NIP</td>
                            <td class="fw-medium"><span class="badge bg-primary-600 fs-6">{{ $pegawai->nip }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Nama Lengkap</td>
                            <td class="fw-semibold">{{ $pegawai->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Jabatan</td>
                            <td class="fw-medium">{{ $pegawai->jabatan }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-secondary-light w-50">Unit Kerja</td>
                            <td class="fw-medium">{{ $pegawai->unit_kerja }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Telepon</td>
                            <td class="fw-medium">{{ $pegawai->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary-light">Alamat</td>
                            <td class="fw-medium">{{ $pegawai->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('spv.pegawai.edit', $pegawai) }}" class="btn btn-warning-600">
            <iconify-icon icon="mdi:pencil" class="icon me-1"></iconify-icon>
            Edit Pegawai
        </a>
        <a href="{{ route('spv.pegawai.index') }}" class="btn btn-secondary">
            <iconify-icon icon="mdi:arrow-left" class="icon me-1"></iconify-icon>
            Kembali
        </a>
    </div>
</div>
@endsection
