@extends('layouts.app')

@section('title', 'Data Pinjaman')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Data Pinjaman</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Pinjaman</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <h6 class="card-title mb-0">Daftar Pinjaman</h6>

            <div class="d-flex gap-2">
                <a href="{{ route('admin-sp.pinjaman.index') }}?status=all" class="btn btn-sm {{ $status == 'all' ? 'btn-primary-600' : 'btn-outline-primary-600' }}">Semua</a>
                <a href="{{ route('admin-sp.pinjaman.index') }}?status=Aktif" class="btn btn-sm {{ $status == 'Aktif' ? 'btn-success-600' : 'btn-outline-success-600' }}">Aktif</a>
                <a href="{{ route('admin-sp.pinjaman.index') }}?status=Lunas" class="btn btn-sm {{ $status == 'Lunas' ? 'btn-info-600' : 'btn-outline-info-600' }}">Lunas</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">ID Pinjaman</th>
                            <th scope="col">Anggota</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Sisa</th>
                            <th scope="col">Tenor</th>
                            <th scope="col">Bunga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pinjaman as $item)
                        <tr>
                            <td>
                                <a href="{{ route('admin-sp.pinjaman.show', $item) }}" class="text-primary-600 fw-medium">#{{ $item->id }}</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-md mb-0 fw-medium">{{ $item->anggota->user->name }}</h6>
                                        <span class="text-sm text-secondary-light">{{ $item->anggota->nomor_anggota }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->tanggal_pinjaman->format('d M Y') }}</td>
                            <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                            <td class="fw-semibold text-warning-main">Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}</td>
                            <td>{{ $item->tenor }} Bulan</td>
                            <td>{{ number_format($item->bunga, 2) }}%</td>
                            <td>
                                <span class="{{ $item->status == 'Aktif' ? 'bg-success-focus text-success-main' : 'bg-info-focus text-info-main' }} px-24 py-4 rounded-pill fw-medium text-sm">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin-sp.pinjaman.show', $item) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Lihat Detaill">
                                        <iconify-icon icon="mdi:eye"></iconify-icon>
                                    </a>
                                    <form action="{{ route('admin-sp.pinjaman.destroy', $item->id) }}" class="w-32-px h-32-px bg-danger-light text-danger-600 rounded-circle d-inline-flex align-items-center justify-content-center" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pinjaman anggota ini? Data angsuran terkait juga akan dihapus permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" data-bs-toggle="tooltip" title="Hapus Pinjaman">
                                            <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
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
<script>
    let table = new DataTable("#dataTable");
</script>
@endpush
