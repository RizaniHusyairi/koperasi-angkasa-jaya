@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Invoice</h6>
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
            <li class="fw-medium">Edit</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <form action="{{ route('staff-keuangan.invoice.update', $invoice->id) }}" method="POST" id="invoiceForm">
                @csrf
                @method('PUT')
                <div class="row gy-4">
                    {{-- Input Data Utama Invoice --}}
                    <div class="col-md-6">
                        <label for="invoice_number" class="form-label fw-semibold text-primary-light text-sm mb-8">No. Invoice</label>
                        <input type="text" class="form-control radius-8" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}" required>
                        @error('invoice_number')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal</label>
                        <input type="date" class="form-control radius-8" id="date" name="date" value="{{ old('date', $invoice->date) }}" required>
                        @error('date')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Tipe Jasa/Sewa</label>
                        <input type="text" class="form-control radius-8" id="type" name="type" value="{{ old('type', $invoice->type) }}" required>
                        @error('type')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="partner_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nama Mitra</label>
                        <input type="text" class="form-control radius-8" id="partner_name" name="partner_name" value="{{ old('partner_name', $invoice->partner_name) }}" required>
                        @error('partner_name')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="activity" class="form-label fw-semibold text-primary-light text-sm mb-8">Kegiatan</label>
                        <input type="text" class="form-control radius-8" id="activity" name="activity" value="{{ old('activity', $invoice->activity) }}" required>
                        @error('activity')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-24">
                    <div class="d-flex align-items-center justify-content-between mb-16">
                        <h6 class="fw-semibold mb-0">Item Invoice</h6>
                        <button type="button" class="btn btn-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2" id="addItemBtn">
                            <iconify-icon icon="mingcute:add-line" class="text-xl"></iconify-icon>
                            Tambah Item
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    {{-- Kolom Tipe Baris Ditambahkan --}}
                                    <th scope="col" width="20%">Tipe Baris</th>
                                    <th scope="col" width="50%">Uraian</th>
                                    <th scope="col" width="20%">Jumlah (Rp)</th>
                                    <th scope="col" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsContainer">
                                {{-- Items will be added here via JS --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-semibold">Total</td>
                                    <td class="fw-semibold" id="totalAmount">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @error('items')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3 mt-24">
                    <a href="{{ route('staff-keuangan.invoice.index') }}" class="btn btn-secondary-light radius-8 px-20 py-11">Batal</a>
                    <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsContainer = document.getElementById('itemsContainer');
        const addItemBtn = document.getElementById('addItemBtn');
        const totalAmountEl = document.getElementById('totalAmount');
        const form = document.getElementById('invoiceForm');

        let itemIndex = 0;

        function formatRupiah(angka) {
            if (!angka) return '';
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }

        function cleanRupiah(rupiah) {
            return rupiah.replace(/[^0-9]/g, '');
        }

        function calculateTotal() {
            let total = 0;
            const amountInputs = document.querySelectorAll('.item-amount');
            amountInputs.forEach(input => {
                const value = cleanRupiah(input.value);
                if (value) {
                    total += parseInt(value);
                }
            });
            totalAmountEl.textContent = formatRupiah(total.toString());
        }

        // Fungsi addItem diperbarui menerima parameter 'type'
        function addItem(description = '', amount = '', type = 'item') {
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>
                    <select class="form-select radius-8 item-type" name="items[${itemIndex}][type]" onchange="adjustRowStyle(this)">
                        <option value="header" ${type === 'header' ? 'selected' : ''}>Judul Utama (Bold)</option>
                        <option value="subheader" ${type === 'subheader' ? 'selected' : ''}>Sub-Judul (Indent 1)</option>
                        <option value="item" ${type === 'item' ? 'selected' : ''}>Item List (Indent 2)</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control radius-8 item-desc" name="items[${itemIndex}][description]" value="${description}" required placeholder="Masukkan uraian">
                </td>
                <td>
                    <input type="text" class="form-control radius-8 item-amount" name="items[${itemIndex}][amount]" value="${amount}" placeholder="Rp 0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger-100 text-danger-600 radius-8 p-10 d-flex align-items-center justify-content-center delete-item">
                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                    </button>
                </td>
            `;
            itemsContainer.appendChild(row);

            const amountInput = row.querySelector('.item-amount');
            const typeSelect = row.querySelector('.item-type');

            if (amount) {
                amountInput.value = formatRupiah(amount.toString());
            }

            amountInput.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
                calculateTotal();
            });

            row.querySelector('.delete-item').addEventListener('click', function() {
                row.remove();
                calculateTotal();
            });

            // Terapkan style awal sesuai tipe
            adjustRowStyle(typeSelect);

            itemIndex++;
            calculateTotal();
        }

        // Fungsi global agar bisa dipanggil dari 'onchange' di HTML string
        window.adjustRowStyle = function(selectElement) {
            const row = selectElement.closest('tr');
            const descInput = row.querySelector('.item-desc');
            
            // Reset style dasar
            descInput.style.fontWeight = 'normal';
            descInput.style.paddingLeft = '12px'; // Default Bootstrap padding

            if (selectElement.value === 'header') {
                descInput.style.fontWeight = 'bold';
                // Header biasanya tidak perlu indent
            } else if (selectElement.value === 'subheader') {
                descInput.style.fontWeight = '500';
                descInput.style.paddingLeft = '30px'; // Indentasi Level 1
            } else {
                // Item biasa
                descInput.style.paddingLeft = '50px'; // Indentasi Level 2
            }
        };

        addItemBtn.addEventListener('click', function() {
            addItem(); // Default tambah item kosong
        });

        // --- LOGIC LOADING DATA (PENTING) ---
        
        // 1. Cek jika ada input 'old' (misal validasi gagal)
        @if(old('items'))
            @foreach(old('items') as $key => $item)
                addItem(
                    '{{ addslashes($item['description']) }}', 
                    '{{ $item['amount'] }}',
                    '{{ $item['type'] }}' // Ambil tipe dari old input
                );
            @endforeach

        // 2. Jika tidak ada old input, ambil dari Database
        @elseif($invoice->items->count() > 0)
            @foreach($invoice->items as $item)
                addItem(
                    '{{ addslashes($item->description) }}', 
                    '{{ (int) $item->amount }}',
                    '{{ $item->item_type }}' // Ambil tipe dari kolom database
                );
            @endforeach
        @else
            // 3. Jika data kosong sama sekali (jarang terjadi di edit)
            addItem();
        @endif

        form.addEventListener('submit', function(e) {
            const amountInputs = document.querySelectorAll('.item-amount');
            amountInputs.forEach(input => {
                input.value = cleanRupiah(input.value);
            });
        });
    });
</script>
@endsection