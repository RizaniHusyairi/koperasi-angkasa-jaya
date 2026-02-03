@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Keranjang Belanja</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('anggota.mini-market.index') }}" class="hover-text-primary">Mini Market</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Keranjang</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-24" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Item Keranjang</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cart as $id => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($item['image']) && $item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" alt="" class="w-48-px h-48-px rounded-circle object-fit-cover me-3">
                                            @else
                                                <div class="w-48-px h-48-px rounded-circle bg-secondary-50 d-flex align-items-center justify-content-center text-secondary-600 me-3">
                                                    <iconify-icon icon="bi:image" class="text-xl"></iconify-icon>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="text-md mb-0 fw-medium">{{ $item['name'] }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td class="text-end fw-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('anggota.mini-market.cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center border-0">
                                                <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-24 text-secondary-light">Keranjang belanja kosong</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($cart) > 0)
                <div class="card-footer py-16 px-24 bg-base">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('anggota.mini-market.index') }}" class="btn btn-outline-primary-600 radius-8 px-20">Lanjut Belanja</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Ringkasan Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-12">
                        <span class="text-secondary-light">Total Belanja</span>
                        <span class="fw-bold text-primary-600 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr class="my-24">
                    
                    <form action="{{ route('anggota.mini-market.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-24">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Metode Pembayaran</label>
                            
                            <div class="form-check d-flex align-items-center gap-2 mb-12">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_limit" value="Limit" checked onchange="toggleLimitInfo()">
                                <label class="form-check-label text-secondary-light cursor-pointer" for="pay_limit">
                                    Potong Gaji / Limit Pinjaman
                                </label>
                            </div>
                            
                            <!-- Limit Info Box -->
                            <div id="limitInfo" class="alert alert-primary bg-primary-50 text-primary-600 border-primary-100 p-12 radius-8 mb-12">
                                <span class="d-block text-xs fw-semibold">Sisa Limit Tersedia:</span>
                                <h6 class="mb-0 fw-bold text-primary-600">Rp {{ number_format($remainingLimit, 0, ',', '.') }}</h6>
                            </div>
                            
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_transfer" value="Transfer" onchange="toggleLimitInfo()">
                                <label class="form-check-label text-secondary-light cursor-pointer" for="pay_transfer">
                                    Transfer Bank (Manual)
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-600 w-100 radius-8 py-12" {{ count($cart) == 0 ? 'disabled' : '' }}>
                            Checkout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleLimitInfo() {
        const isLimit = document.getElementById('pay_limit').checked;
        const limitInfo = document.getElementById('limitInfo');
        if (isLimit) {
            limitInfo.style.display = 'block';
        } else {
            limitInfo.style.display = 'none';
        }
    }
</script>
@endsection
