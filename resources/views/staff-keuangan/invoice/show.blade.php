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
                    <p class="text-secondary-light mb-0">Tanggal: {{ \Carbon\Carbon::parse($invoice->date)->locale('id')->isoFormat('D MMMM Y') }}</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- Tombol Print Sederhana --}}
                    <a href="{{ route('staff-keuangan.invoice.pdf', $invoice->id) }}" target="_blank" class="btn btn-primary-100 text-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <iconify-icon icon="mingcute:print-line" class="text-xl"></iconify-icon>
                        Cetak PDF
                    </a>
                    <a href="{{ route('staff-keuangan.invoice.edit', $invoice->id) }}" class="btn btn-warning-main radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <iconify-icon icon="lucide:edit" class="text-xl"></iconify-icon>
                        Edit
                    </a>
                    <a href="{{ route('staff-keuangan.invoice.index') }}" class="btn btn-secondary-light radius-8 px-20 py-11">Kembali</a>
                </div>
            </div>

            <hr class="mb-24">

            {{-- Informasi Header Invoice --}}
            <div class="row gy-4 mb-24 p-16 radius-8 bg-base-50">
                <div class="col-sm-6">
                    <h6 class="fw-semibold text-primary-light mb-8 text-uppercase text-xs tracking-wider">Kepada Yth (Mitra)</h6>
                    <h6 class="fw-bold mb-0 text-lg">{{ $invoice->partner_name }}</h6>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <h6 class="fw-semibold text-primary-light mb-8 text-uppercase text-xs tracking-wider">Tipe Jasa/Sewa</h6>
                    <h6 class="fw-bold mb-0">{{ $invoice->type }}</h6>
                </div>
                <div class="col-12">
                    <h6 class="fw-semibold text-primary-light mb-8 text-uppercase text-xs tracking-wider">Kegiatan</h6>
                    <p class="fw-medium mb-0 text-secondary-light">{{ $invoice->activity }}</p>
                </div>
            </div>

            {{-- Tabel Rincian --}}
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead class="bg-base">
                        <tr>
                            <th scope="col" class="text-start py-3 px-4">Uraian</th>
                            <th scope="col" class="text-end py-3 px-4" width="25%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            {{-- LOGIC STYLE BERDASARKAN TIPE --}}
                            <td class="
                                px-4
                                @if($item->item_type == 'header') fw-bold text-primary-800 @endif
                                @if($item->item_type == 'subheader') ps-5 fw-semibold text-secondary @endif
                                @if($item->item_type == 'item') ps-5 ms-4 text-secondary-light @endif
                            " 
                            style="
                                @if($item->item_type == 'item') padding-left: 3rem !important; @endif
                            ">
                                {{-- Jika item biasa, tambahkan bullet/dash kecil biar rapi --}}
                                @if($item->item_type == 'item') - @endif 
                                {{ $item->description }}
                            </td>
                            
                            <td class="text-end px-4">
                                {{-- Header biasanya tidak punya harga, jadi di-hide kalau 0 --}}
                                @if($item->amount > 0)
                                    <span class="fw-medium text-primary-600">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-primary-50">
                            <td class="text-end fw-bold text-primary-900 px-4 py-3">TOTAL TAGIHAN</td>
                            <td class="text-end fw-bold text-primary-900 text-lg px-4 py-3">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        {{-- Baris Terbilang (Opsional - Agar mirip PDF) --}}
                        <tr>
                            <td colspan="2" class="px-4 py-3 fst-italic text-secondary-light">
                                <span class="fw-semibold text-primary-light">Terbilang: </span> 
                                {{-- Fungsi terbilang bisa ditambahkan di helper nanti, sementara hardcode/placeholder --}}
                                # 
                                @php
                                    // Contoh logic sederhana terbilang (sebaiknya dipindah ke Helper)
                                    $angka = $invoice->total_amount;
                                    // ... logic terbilang ...
                                    echo "Harap cek nominal manual"; 
                                @endphp 
                                #
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            {{-- Footer Info Transfer (Sesuai PDF) --}}
            <div class="mt-24 p-16 border radius-8 d-flex align-items-start gap-3">
                <iconify-icon icon="solar:card-outline" class="text-2xl text-primary-600 mt-1"></iconify-icon>
                <div>
                    <h6 class="fw-bold mb-1 text-sm">Informasi Pembayaran</h6>
                    <p class="text-secondary-light text-sm mb-1">Silakan transfer pembayaran ke:</p>
                    <ul class="list-unstyled mb-0 text-sm fw-medium text-primary-900">
                        <li>Bank: <span class="fw-bold">BANK TABUNGAN NEGARA (BTN)</span></li>
                        <li>No. Rekening: <span class="fw-bold">200-188-000-1341</span></li>
                        <li>A.N: <span class="fw-bold">PT ANGKASA JAYA SERVIS</span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- CSS Khusus untuk Print (Agar tombol hilang saat diprint) --}}
<style>
    @media print {
        .dashboard-main-body > div:first-child, /* Breadcrumb */
        .btn, /* Semua tombol */
        .dashboard-sidebar, /* Sidebar (jika ada) */
        .dashboard-header /* Header atas (jika ada) */
        {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection