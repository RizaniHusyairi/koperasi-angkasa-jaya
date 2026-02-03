@extends('layouts.app')

@section('title', 'Mini Market Koperasi')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Halaman Belanja</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('anggota.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Mini Market</li>
        </ul>
    </div>

    <!-- Search & Cart -->
    <div class="card mb-24 radius-12 p-3">
        <div class="row gy-3 align-items-center justify-content-between">
            <div class="col-md-6 col-lg-5">
                <form action="{{ route('anggota.mini-market.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control radius-8" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary-600 radius-8 px-20">
                        <iconify-icon icon="mdi:magnify" class="text-xl"></iconify-icon>
                    </button>
                </form>
            </div>
            <div class="col-md-6 col-lg-auto d-flex gap-2 justify-content-md-end">
                <a href="{{ route('anggota.mini-market.cart') }}" class="btn btn-warning-600 radius-8 px-20 d-flex align-items-center gap-2 position-relative">
                    <iconify-icon icon="mdi:cart-outline" class="text-xl"></iconify-icon>
                    Keranjang
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger-600 border border-white">
                        {{ $cartCount }}
                        <span class="visually-hidden">item di keranjang</span>
                    </span>
                </a>
                <a href="{{ route('anggota.mini-market.orders') }}" class="btn btn-secondary-50 text-secondary-600 radius-8 px-20 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:history" class="text-xl"></iconify-icon>
                    Riwayat
                </a>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        @forelse($products as $product)
        <div class="col-xxl-3 col-xl-4 col-sm-6">
            <div class="card h-100 radius-12 hover-scale-img overflow-hidden">
                <div class="card-img-top position-relative overflow-hidden h-200-px">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover hover-scale-img-item">
                    @else
                        <div class="w-100 h-100 bg-secondary-50 d-flex align-items-center justify-content-center text-secondary-300">
                            <iconify-icon icon="bi:image" class="text-6xl"></iconify-icon>
                        </div>
                    @endif
                    
                    <div class="position-absolute top-0 end-0 p-12">
                         <span class="badge {{ $product->stock > 0 ? 'bg-success-600' : 'bg-danger-600' }} text-white text-sm py-4 px-12 radius-4">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-16 d-flex flex-column">
                    <span class="text-secondary-light text-xs mb-4">{{ $product->category ?? 'Umum' }}</span>
                    <h6 class="text-md mb-8 fw-semibold text-primary-light line-clamp-2" style="min-height: 2.4em;">
                        {{ $product->name }}
                    </h6>
                    <div class="d-flex align-items-end justify-content-between mt-auto">
                        <div>
                            <span class="text-sm text-secondary-light d-block">Harga</span>
                            <h6 class="text-lg fw-bold text-primary-600 mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                        </div>
                        <form action="{{ route('anggota.mini-market.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary-100 text-primary-600 w-32-px h-32-px p-0 rounded-circle d-flex align-items-center justify-content-center hover-bg-primary-600 hover-text-white transition-2" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <iconify-icon icon="mdi:plus" class="text-xl"></iconify-icon>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card h-100 p-4">
                <div class="text-center py-5">
                    <iconify-icon icon="mdi:package-variant" class="text-6xl text-secondary-200 mb-3"></iconify-icon>
                    <h5 class="text-secondary-light">Belum ada produk tersedia.</h5>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-24">
        {{ $products->links() }}
    </div>
</div>
@endsection
