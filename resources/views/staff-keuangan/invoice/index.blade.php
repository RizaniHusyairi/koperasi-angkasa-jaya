@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Manajemen Invoice</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('staff-keuangan.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Invoice</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <h5 class="card-title mb-0">List Invoice</h5>
            <a href="{{ route('staff-keuangan.invoice.create') }}" class="btn btn-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                <iconify-icon icon="mingcute:add-line" class="text-xl"></iconify-icon>
                Tambah Invoice
            </a>
        </div>
        <div class="card-body p-24">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">No. Invoice</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Mitra</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->type }}</td>
                            <td>{{ $invoice->partner_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($invoice->status == 'Sudah dibayar')
                                    <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Sudah dibayar</span>
                                @else
                                    <span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Belum dibayar</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('staff-keuangan.invoice.show', $invoice->id) }}" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                                        <iconify-icon icon="mingcute:eye-2-line"></iconify-icon>
                                    </a>
                                    <a href="{{ route('staff-keuangan.invoice.edit', $invoice->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Edit">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <form action="{{ route('staff-keuangan.invoice.destroy', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center border-0" title="Hapus">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data invoice.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
