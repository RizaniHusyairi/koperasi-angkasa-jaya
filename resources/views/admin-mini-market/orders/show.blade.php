@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->code)

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Pesanan {{ $order->code }}</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.orders.index') }}" class="hover-text-primary">Pesanan</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex justify-content-between align-items-center">
                    <h6 class="text-lg fw-semibold mb-0">Invoice #{{ $order->code }}</h6>
                     <div class="d-flex gap-2">
                         <a href="{{ route('admin-mini-market.orders.print', $order->id) }}" target="_blank" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                            Print
                        </a>
                    </div>
                </div>
                <div class="card-body py-40">
                    <div class="row justify-content-center" id="invoice">
                        <div class="col-lg-12">
                            <div class="shadow-4 border radius-8">
                                <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div>
                                        <h3 class="text-xl">Invoice #{{ $order->code }}</h3>
                                        <p class="mb-1 text-sm">Tanggal: {{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <img src="{{ $setting->logo_url ?? asset('assets/logo/logo_koperasi.png') }}" alt="image" class="mb-8" style="max-height: 40px;">
                                        <p class="mb-1 text-sm">{{ $setting->company_name ?? 'Koperasi Angkasa Jaya' }}</p>
                                        <p class="mb-0 text-sm">{{ $setting->company_email ?? 'koperasi@angkasajaya.com' }}</p>
                                    </div>
                                </div>
                                <div class="py-28 px-20">
                                    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                        <div>
                                            <h6 class="text-md">Tagihan Kepada:</h6>
                                            <table class="text-sm text-secondary-light">
                                                <tbody>
                                                    <tr>
                                                        <td>Nama</td>
                                                        <td class="ps-8">: {{ $order->user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td class="ps-8">: {{ $order->user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>WhatsApp</td>
                                                        <td class="ps-8">: 
                                                            @if($order->user->anggota?->nomor_wa)
                                                                <a href="https://wa.me/{{ $order->user->anggota->nomor_wa }}" target="_blank" class="text-primary-600 hover-text-primary-800">
                                                                    {{ $order->user->anggota->nomor_wa }}
                                                                </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pembayaran</td>
                                                        <td class="ps-8">: {{ $order->payment_method }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <table class="text-sm text-secondary-light">
                                                <tbody>
                                                    <tr>
                                                        <td>Waktu Pesanan</td>
                                                        <td class="ps-8">: {{ $order->created_at->format('d M Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ID Pesanan</td>
                                                        <td class="ps-8">: #{{ $order->code }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mt-24">
                                        <div class="table-responsive scroll-sm">
                                            <table class="table bordered-table text-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-sm">No.</th>
                                                        <th scope="col" class="text-sm">Deskripsi Barang</th>
                                                        <th scope="col" class="text-sm">Jumlah</th>
                                                        <th scope="col" class="text-sm">Harga Satuan</th>
                                                        <th scope="col" class="text-end text-sm">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->orderItems as $index => $item)
                                                    <tr>
                                                        <td>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center"> 
                                                                <div class="flex-grow-1">
                                                                    <h6 class="text-md mb-0 fw-medium">{{ $item->product->name }}</h6>
                                                                    <span class="text-sm text-secondary-light">{{ $item->product->category }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-between gap-3 mt-3">
                                            <div>
                                                <p class="text-sm mb-0">Terima kasih telah berbelanja</p>
                                            </div>
                                            <div>
                                                <table class="text-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="pe-64 pt-4">
                                                                <span class="text-primary-light fw-semibold">Total:</span>
                                                            </td>
                                                            <td class="pe-16 pt-4">
                                                                <span class="text-primary-light fw-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-64">
                                        <p class="text-center text-secondary-light text-sm fw-semibold">Terima kasih atas pembelian Anda!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card mb-24">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Status Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary-light text-sm">Status Saat Ini</label>
                        <br>
                        @php
                            $statusClass = match($order->status) {
                                'Pending' => 'bg-warning-50 text-warning-600',
                                'Processing' => 'bg-info-50 text-info-600',
                                'Completed' => 'bg-success-50 text-success-600',
                                'Cancelled' => 'bg-danger-50 text-danger-600',
                                default => 'bg-secondary-50 text-secondary-600',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} rounded-pill px-12 py-6 text-sm">{{ $order->status }}</span>
                    </div>

                    <form action="{{ route('admin-mini-market.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold text-primary-light text-sm">Ubah Status</label>
                            <select class="form-select form-control radius-8" name="status" id="status">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary-600 w-100 radius-8">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
