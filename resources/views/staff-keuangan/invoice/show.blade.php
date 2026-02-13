@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Invoice</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('staff-keuangan.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('staff-keuangan.invoice.index') }}" class="hover-text-primary">Invoice</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="card radius-12 overflow-hidden">
        <div class="card-body p-24">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <div>
                    <h5 class="fw-semibold mb-1">Invoice #{{ $invoice->invoice_number }}</h5>
                    <p class="text-secondary-light mb-0">Tanggal: {{ \Carbon\Carbon::parse($invoice->date)->format('d F Y') }}</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('staff-keuangan.invoice.edit', $invoice->id) }}" class="btn btn-warning-main radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <iconify-icon icon="lucide:edit" class="text-xl"></iconify-icon>
                        Edit
                    </a>
                    <a href="{{ route('staff-keuangan.invoice.index') }}" class="btn btn-secondary-light radius-8 px-20 py-11">Kembali</a>
                </div>
            </div>

            <hr class="mb-24">

            <div class="row gy-4 mb-24">
                <div class="col-sm-6">
                    <h6 class="fw-semibold text-primary-light mb-8 text-uppercase opacity-50">Informasi Mitra</h6>
                    <h6 class="fw-bold mb-0">{{ $invoice->partner_name }}</h6>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <h6 class="fw-semibold text-primary-light mb-8 text-uppercase opacity-50">Tipe Jasa/Sewa</h6>
                    <h6 class="fw-bold mb-0">{{ $invoice->type }}</h6>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead class="bg-base">
                        <tr>
                            <th scope="col" class="text-start">Uraian</th>
                            <th scope="col" class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            <td class="text-start">{{ $item->description }}</td>
                            <td class="text-end">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-base">
                            <td class="text-end fw-bold">TOTAL</td>
                            <td class="text-end fw-bold text-primary-600 text-lg">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
