@extends('layouts.app')

@section('title', 'Catat Stok Keluar - Mini Market')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Catat Stok Keluar</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.stocks.index') }}" class="hover-text-primary">Riwayat Stok</a>
            </li>
            <li>-</li>
            <li class="fw-medium">Stok Keluar</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12 col-md-8 mx-auto">
        <div class="card-header border-bottom bg-base py-16 px-24">
            <div class="alert alert-warning mb-0 radius-8">
                <div class="d-flex align-items-start gap-2">
                    <iconify-icon icon="mdi:alert-circle-outline" class="text-xl text-warning-600 mt-1"></iconify-icon>
                    <div>
                        <h6 class="text-sm fw-semibold mb-1 text-warning-600">Perhatian</h6>
                        <p class="text-sm mb-0">Gunakan menu ini hanya untuk <b>pengurangan stok manual</b> (seperti barang rusak, kedaluwarsa, atau hilang). Pengurangan karena pesanan/belanja anggota berjalan otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-24">
            <form action="{{ route('admin-mini-market.stocks.out.store') }}" method="POST">
                @csrf
                <div class="row gy-4">
                    <div class="col-12">
                        <label for="product_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Pilih Produk <span class="text-danger-600">*</span></label>
                        <select class="form-control radius-8 form-select" id="product_id" name="product_id" required>
                            <option value="">Pilih Produk...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stok saat ini: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="quantity" class="form-label fw-semibold text-primary-light text-sm mb-8">Jumlah Keluar (Kuantitas) <span class="text-danger-600">*</span></label>
                        <input type="number" class="form-control radius-8" id="quantity" name="quantity" placeholder="Masukkan jumlah barang keluar" value="{{ old('quantity') }}" required min="1">
                        @error('quantity')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label fw-semibold text-primary-light text-sm mb-8">Keterangan / Alasan (Wajib)</label>
                        <textarea class="form-control radius-8" id="notes" name="notes" rows="3" placeholder="Contoh: Barang kadaluarsa / Kemasan rusak" required>{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 border-top pt-24 mt-24">
                        <div class="bg-danger-50 p-3 radius-8 mb-24">
                            <h6 class="text-sm fw-semibold text-danger-600 mb-1">Preview Stok Baru</h6>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-md fw-medium" id="preview_old">0</span>
                                <span class="text-danger-600 fw-bold">- <span id="preview_sub">0</span></span>
                                <span class="text-md fw-bold">= <span id="preview_new">0</span></span>
                            </div>
                            <span class="text-xs text-danger mt-1 d-none" id="error_msg">Kuantitas melebihi stok yang ada!</span>
                        </div>
                    </div>
                    
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin-mini-market.stocks.index') }}" class="btn btn-secondary-50 text-secondary-600 radius-8 px-20 py-11">Batal</a>
                        <button type="submit" class="btn btn-danger radius-8 px-20 py-11" id="btn_submit">Simpan Stok Keluar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const previewOld = document.getElementById('preview_old');
        const previewSub = document.getElementById('preview_sub');
        const previewNew = document.getElementById('preview_new');
        const errorMsg = document.getElementById('error_msg');
        const btnSubmit = document.getElementById('btn_submit');

        function updatePreview() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            let oldStock = 0;
            
            if(selectedOption && selectedOption.value) {
                oldStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            }
            
            const subQuantity = parseInt(quantityInput.value) || 0;
            const newStock = oldStock - Math.max(0, subQuantity);

            previewOld.textContent = oldStock;
            previewSub.textContent = Math.max(0, subQuantity);
            previewNew.textContent = newStock;

            if (newStock < 0) {
                errorMsg.classList.remove('d-none');
                btnSubmit.disabled = true;
                previewNew.classList.add('text-danger');
            } else {
                errorMsg.classList.add('d-none');
                btnSubmit.disabled = false;
                previewNew.classList.remove('text-danger');
            }
        }

        productSelect.addEventListener('change', updatePreview);
        quantityInput.addEventListener('input', updatePreview);
        
        // Initial call
        updatePreview();
    });
</script>
@endsection
