@extends('layouts.app')

@section('title', 'Edit Produk - Mini Market')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Produk</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.products.index') }}" class="hover-text-primary">Produk</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Edit</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <form action="{{ route('admin-mini-market.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row gy-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nama Produk <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8" id="name" name="name" placeholder="Masukkan nama produk" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="category" class="form-label fw-semibold text-primary-light text-sm mb-8">Kategori</label>
                        <select class="form-control radius-8 form-select" id="category" name="category">
                            <option value="">Pilih Kategori</option>
                            <option value="Sembako" {{ old('category', $product->category) == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                            <option value="Minuman" {{ old('category', $product->category) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Makanan Ringan" {{ old('category', $product->category) == 'Makanan Ringan' ? 'selected' : '' }}>Makanan Ringan</option>
                            <option value="Perlengkapan Mandi" {{ old('category', $product->category) == 'Perlengkapan Mandi' ? 'selected' : '' }}>Perlengkapan Mandi</option>
                            <option value="Lainnya" {{ old('category', $product->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold text-primary-light text-sm mb-8">Harga (Rp) <span class="text-danger-600">*</span></label>
                        <input type="number" class="form-control radius-8" id="price" name="price" placeholder="0" value="{{ old('price', $product->price) }}" required min="0">
                        @error('price')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label fw-semibold text-primary-light text-sm mb-8">Stok <span class="text-danger-600">*</span></label>
                        <input type="number" class="form-control radius-8" id="stock" name="stock" placeholder="0" value="{{ old('stock', $product->stock) }}" required min="0">
                        @error('stock')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">Deskripsi Produk</label>
                        <textarea class="form-control radius-8" id="description" name="description" rows="3" placeholder="Masukkan deskripsi produk">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label fw-semibold text-sm mb-8">Gambar Produk</label>
                        @if($product->image)
                            <div class="mb-3">
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-120-px h-120-px rounded-3 object-fit-cover">
                            </div>
                        @endif
                        <input type="file" class="form-control radius-8" id="image" name="image" accept="image/*">
                        <div class="text-sm">Biarkan kosong jika tidak ingin mengubah gambar. Format: jpg, png, gif. Maks: 2MB.</div>
                        @error('image')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin-mini-market.products.index') }}" class="btn btn-secondary-50 text-secondary-600 radius-8 px-20 py-11">Batal</a>
                        <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
