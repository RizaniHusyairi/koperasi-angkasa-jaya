@extends('layouts.app')

@section('title', 'Manajemen Anggota Koperasi')

@push('styles')
<!-- Data Table css -->
<link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
@endpush

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Manajemen Anggota Koperasi</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('superadmin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Anggota Koperasi</li>
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

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Anggota Koperasi</h5>
            <a href="{{ route('superadmin.anggota.create') }}" class="btn btn-primary-600">
                <iconify-icon icon="mdi:plus" class="icon me-1"></iconify-icon>
                Tambah Anggota
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
                    <thead>
                            <th scope="col">No</th>
                            <th scope="col">Nomor Anggota</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status Pegawai</th>
                            <th scope="col">Status Keanggotaan</th>
                            <th scope="col">Limit Pinjaman</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $index => $item)
                        <tr>
                            <td>{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td><a href="{{ route('superadmin.anggota.show', $item) }}" class="text-primary-600 fw-medium">{{ $item->nomor_anggota }}</a></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/images/user-list/user-list1.png') }}" alt="{{ $item->user->name }}" class="flex-shrink-0 me-12 radius-8" style="width: 40px; height: 40px;">
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $item->user->name }}</h6>
                                </div>
                            </td>
                            <td>{{ $item->user->email }}</td>
                            <td>
                                <span class="bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm">{{ $item->status_pegawai }}</span>
                            </td>
                            <td>
                                <span class="{{ $item->status_keanggotaan == 'Aktif' ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }} px-24 py-4 rounded-pill fw-medium text-sm">
                                    {{ $item->status_keanggotaan }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($item->limit_pinjaman, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('superadmin.anggota.show', $item) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="mdi:eye"></iconify-icon>
                                </a>
                                <a href="{{ route('superadmin.anggota.edit', $item) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="mdi:pencil"></iconify-icon>
                                </a>
                                <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center border-0" onclick="confirmDelete({{ $item->id }})">
                                    <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('superadmin.anggota.destroy', $item) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Data Table JS -->
<script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
<script>
    // Initialize DataTable
    let table = new DataTable('#dataTable', {
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Tidak ada data yang ditemukan",
            emptyTable: "Tidak ada data yang tersedia",
            paginate: {
                first: '<iconify-icon icon="mdi:chevron-double-left"></iconify-icon>',
                previous: '<iconify-icon icon="mdi:chevron-left"></iconify-icon>',
                next: '<iconify-icon icon="mdi:chevron-right"></iconify-icon>',
                last: '<iconify-icon icon="mdi:chevron-double-right"></iconify-icon>'
            }
        }
    });

    // Confirm Delete
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus anggota ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
