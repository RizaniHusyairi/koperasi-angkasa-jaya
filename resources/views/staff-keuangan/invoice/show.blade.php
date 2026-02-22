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
                    <h5 class="fw-semibold mb-1 d-flex align-items-center gap-2">
                        Invoice #{{ $invoice->invoice_number }}
                        @if($invoice->status == 'Sudah dibayar')
                            <span class="bg-success-focus text-success-main px-12 py-4 rounded-pill fw-medium text-sm">Sudah dibayar</span>
                        @else
                            <span class="bg-danger-focus text-danger-main px-12 py-4 rounded-pill fw-medium text-sm">Belum dibayar</span>
                        @endif
                    </h5>
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
                                @if($item->item_type == 'header') fw-bold text-primary-main @endif
                                @if($item->item_type == 'subheader') ps-5 fw-semibold text-secondary-light @endif
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
                        <tr class="bg-primary-light">
                            <td class="text-end fw-bold text-primary-main px-4 py-3">TOTAL TAGIHAN</td>
                            <td class="text-end fw-bold text-primary-main text-lg px-4 py-3">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        {{-- Baris Terbilang (Opsional - Agar mirip PDF) --}}
                        <tr>
                            <td colspan="2" class="px-4 py-3 fst-italic text-secondary-light">
                                    
                                <span class="fw-semibold text-primary-light">Terbilang: {{ terbilang($invoice->total_amount) }} Rupiah</span> 
                                {{-- Fungsi terbilang bisa ditambahkan di helper nanti, sementara hardcode/placeholder --}}
                                
                                <!-- @php
                                    // Contoh logic sederhana terbilang (sebaiknya dipindah ke Helper)
                                    $angka = $invoice->total_amount;
                                    echo "Harap cek nominal manual"; 
                                @endphp  -->
                                
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            {{-- Footer Info Transfer (Sesuai PDF) --}}
            @php
                $setting = \App\Models\StaffKeuanganSetting::first();
            @endphp
            <div class="mt-24 p-16 border radius-8 d-flex align-items-start gap-3">
                <iconify-icon icon="solar:card-outline" class="text-2xl text-primary-600 mt-1"></iconify-icon>
                <div>
                    <h6 class="fw-bold mb-1 text-sm">Informasi Pembayaran</h6>
                    <p class="text-secondary-light text-sm mb-1">Silakan transfer pembayaran ke:</p>
                    <ul class="list-unstyled mb-0 text-sm fw-medium text-primary-main">
                        <li>Bank: <span class="fw-bold">{{ $setting->bank_name ?? 'BANK TABUNGAN NEGARA (BTN)' }}</span></li>
                        <li>No. Rekening: <span class="fw-bold">{{ $setting->bank_account ?? '200-188-000-1341 a/n PT ANGKASA JAYA SERVIS' }}</span></li>
                    </ul>
                </div>
            </div>

            {{-- Informasi atau Form Upload Bukti Pembayaran --}}
            <div class="mt-24">
                <hr>
                <h6 class="fw-bold mb-16 text-md mt-24">Bukti Pembayaran</h6>
                
                @if($invoice->payment_proof)
                    <div class="mb-16">
                        <p class="text-success-main fw-medium d-flex align-items-center gap-2 mb-12">
                            <iconify-icon icon="mingcute:check-circle-fill" class="text-xl"></iconify-icon>
                            Bukti pembayaran telah diunggah.
                        </p>
                        <div class="border radius-8 p-16 d-inline-block bg-base-50">
                            <img src="{{ asset($invoice->payment_proof) }}" alt="Bukti Pembayaran" class="img-fluid radius-8" style="max-width: 400px; max-height: 400px; object-fit: contain;">
                        </div>
                    </div>
                @else
                    <div class="alert alert-info bg-info-100 text-info-600 border-info-200 p-16 d-flex align-items-start gap-2 radius-8">
                        <iconify-icon icon="mingcute:information-line" class="text-xl mt-1"></iconify-icon>
                        <div>
                            <h6 class="text-info-600 text-md mb-2 fw-semibold">Upload Bukti Pembayaran</h6>
                            <p class="mb-12 text-sm">Silakan unggah bukti transfer/pembayaran dari mitra untuk mengubah status invoice menjadi "Sudah dibayar".</p>
                            
                            <form action="{{ route('staff-keuangan.invoice.upload-proof', $invoice->id) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-end gap-3 flex-wrap">
                                @csrf
                                <div class="form-group mb-0 flex-grow-1" style="max-width: 400px;">
                                    <input class="form-control radius-8 bg-base" type="file" name="payment_proof" id="payment_proof" accept="image/jpeg,image/png,image/jpg" required>
                                </div>
                                <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                                    <iconify-icon icon="mingcute:upload-2-line" class="text-lg"></iconify-icon>
                                    Unggah & Verifikasi
                                </button>
                            </form>
                            @error('payment_proof')
                                <div class="text-danger mt-8 text-sm fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif
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