@extends('layouts.app')

@section('title', 'Manajemen Pegawai')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Manajemen Pegawai</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('spv.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Pegawai</li>
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">Daftar Pegawai</h6>
            <a href="{{ route('spv.pegawai.create') }}" class="btn btn-primary-600">
                <iconify-icon icon="mdi:plus" class="icon me-1"></iconify-icon>
                Tambah Pegawai
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>Unit Kerja</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawai as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pegawai->currentPage() - 1) * $pegawai->perPage() }}</td>
                            <td><span class="badge bg-primary-600">{{ $item->nip }}</span></td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->unit_kerja }}</td>
                            <td>{{ $item->telepon ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('spv.pegawai.show', $item) }}" class="btn btn-sm btn-info-600">
                                        <iconify-icon icon="mdi:eye" class="icon"></iconify-icon>
                                    </a>
                                    <a href="{{ route('spv.pegawai.edit', $item) }}" class="btn btn-sm btn-warning-600">
                                        <iconify-icon icon="mdi:pencil" class="icon"></iconify-icon>
                                    </a>
                                    <form action="{{ route('spv.pegawai.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-600">
                                            <iconify-icon icon="mdi:delete" class="icon"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pegawai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $pegawai->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
