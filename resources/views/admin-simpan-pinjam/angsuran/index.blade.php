@extends('layouts.app')

@section('title', 'Riwayat Angsuran')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Riwayat Pembayaran Angsuran</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Angsuran</li>
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Angsuran</h5>
            <a href="{{ route('admin-sp.angsuran.create') }}" class="btn btn-primary-600">
                <iconify-icon icon="mdi:plus" class="icon me-1"></iconify-icon>
                Catat Angsuran Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
                    <thead>
                        <tr>
                            <th scope="col">ID Pinjaman</th>
                            <th scope="col">Anggota</th>
                            <th scope="col">Angsuran Ke</th>
                            <th scope="col">Jumlah Bayar</th>
                            <th scope="col">Denda</th>
                            <th scope="col">Tanggal Bayar</th>
                            <th scope="col">Sisa Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($angsuran as $item)
                        <tr>
                            <td>
                                <a href="{{ route('admin-sp.pinjaman.show', $item->pinjaman) }}" class="text-primary-600 fw-medium">
                                    #{{ $item->pinjaman->id }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-md mb-0 fw-medium">{{ $item->pinjaman->anggota->user->name }}</h6>
                                        <span class="text-sm text-secondary-light">{{ $item->pinjaman->anggota->nomor_anggota }}</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info-focus text-info-main">Ke-{{ $item->angsuran_ke }}</span></td>
                            <td>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($item->denda > 0)
                                    <span class="text-danger-main">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->tanggal_bayar->format('d M Y') }}</td>
                            <td>
                                Rp {{ number_format($item->pinjaman->sisa_pinjaman, 0, ',', '.') }}
                                @if($item->pinjaman->sisa_pinjaman == 0)
                                    <span class="badge bg-success-focus text-success-main ms-1">Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $angsuran->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let table = new DataTable('#dataTable', {
        responsive: true,
        searching: true,
        paging: false, 
        info: false,
        order: [], 
        language: {
            search: "Cari:",
            zeroRecords: "Tidak ada data angsuran ditemukan",
            emptyTable: "Belum ada transaksi angsuran"
        }
    });
</script>
@endpush
