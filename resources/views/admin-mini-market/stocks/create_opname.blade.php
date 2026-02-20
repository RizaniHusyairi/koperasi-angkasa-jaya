@extends('layouts.app')

@section('title', 'Penyesuaian Stok Opname - Mini Market')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Stok Opname (Penyesuaian Fisik)</h6>
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
            <li class="fw-medium">Opname</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12 col-md-8 mx-auto">
        <div class="card-header border-bottom bg-base py-16 px-24">
            <div class="alert alert-info mb-0 radius-8">
                <div class="d-flex align-items-start gap-2">
                    <iconify-icon icon="mdi:information-outline" class="text-xl text-info-600 mt-1"></iconify-icon>
                    <div>
                        <h6 class="text-sm fw-semibold mb-1 text-info-600">Informasi</h6>
                        <p class="text-sm mb-0"><b>Stok Opname</b> digunakan untuk menyamakan/menyesuaikan jumlah stok yang tercatat di sistem dengan hitungan fisik barang asli di rak/gudang penyimpanan.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-24">
            <form action="{{ route('admin-mini-market.stocks.opname.store') }}" method="POST">
                @csrf
                <div class="row gy-4">
                    <div class="col-12">
                        <label for="product_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Pilih Produk <span class="text-danger-600">*</span></label>
                        <select class="form-control radius-8 form-select" id="product_id" name="product_id" required>
                            <option value="">Pilih Produk...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Tercatat di Sistem: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="actual_stock" class="form-label fw-semibold text-primary-light text-sm mb-8">Stok Sebenarnya (Fisik) <span class="text-danger-600">*</span></label>
                        <input type="number" class="form-control radius-8" id="actual_stock" name="actual_stock" placeholder="0" value="{{ old('actual_stock') }}" required min="0">
                        <div class="text-sm mt-1 text-secondary-light">Masukkan angka pasti dari jumlah barang fisik yang dihitung. Sistem akan otomatis merekam selisihnya.</div>
                        @error('actual_stock')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label fw-semibold text-primary-light text-sm mb-8">Keterangan / Alasan (Opsional)</label>
                        <textarea class="form-control radius-8" id="notes" name="notes" rows="3" placeholder="Contoh: Stok opname akhir bulan / Koreksi selisih hitung produk">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 border-top pt-24 mt-24">
                        <div class="bg-gray-50 p-3 radius-8 mb-24" id="preview_box">
                            <h6 class="text-sm fw-semibold text-secondary-600 mb-1">Preview Perubahan</h6>
                            <div class="d-flex align-items-center gap-4 mt-2">
                                <div>
                                    <span class="text-sm text-secondary-light d-block">Stok Sistem:</span>
                                    <span class="text-lg fw-bold" id="preview_old">0</span>
                                </div>
                                <div class="text-secondary-light">
                                    <iconify-icon icon="mdi:arrow-right-bold" class="text-xl"></iconify-icon>
                                </div>
                                <div>
                                    <span class="text-sm text-secondary-light d-block">Stok Opname (Fisik):</span>
                                    <span class="text-lg fw-bold text-primary-600" id="preview_new">0</span>
                                </div>
                                <div class="ms-auto pe-3 text-end">
                                    <span class="text-sm text-secondary-light d-block">Selisih:</span>
                                    <span class="text-lg fw-bold" id="preview_diff">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin-mini-market.stocks.index') }}" class="btn btn-secondary-50 text-secondary-600 radius-8 px-20 py-11">Batal</a>
                        <button type="submit" class="btn btn-warning radius-8 px-20 py-11" id="btn_submit">Simpan Stok Opname</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const actualInput = document.getElementById('actual_stock');
        const previewOld = document.getElementById('preview_old');
        const previewNew = document.getElementById('preview_new');
        const previewDiff = document.getElementById('preview_diff');

        function updatePreview() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            let oldStock = 0;
            
            if(selectedOption && selectedOption.value) {
                oldStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            }
            
            const newStock = parseInt(actualInput.value) || 0;
            const diff = newStock - oldStock;

            previewOld.textContent = oldStock;
            previewNew.textContent = isNaN(parseInt(actualInput.value)) ? '-' : newStock;
            
            if (isNaN(parseInt(actualInput.value))) {
                previewDiff.textContent = '-';
                previewDiff.className = 'text-lg fw-bold text-secondary-light';
            } else if (diff > 0) {
                previewDiff.textContent = '+' + diff;
                previewDiff.className = 'text-lg fw-bold text-success-600';
            } else if (diff < 0) {
                previewDiff.textContent = diff;
                previewDiff.className = 'text-lg fw-bold text-danger-600';
            } else {
                previewDiff.textContent = '0 (Sesuai)';
                previewDiff.className = 'text-lg fw-bold text-success-600';
            }
        }

        productSelect.addEventListener('change', updatePreview);
        actualInput.addEventListener('input', updatePreview);
        
        // Initial call
        updatePreview();
    });
</script>
@endsection
