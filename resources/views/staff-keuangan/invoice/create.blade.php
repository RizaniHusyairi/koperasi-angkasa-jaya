@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Tambah Invoice</h6>
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
            <li class="fw-medium">Tambah</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <form action="{{ route('staff-keuangan.invoice.store') }}" method="POST" id="invoiceForm">
                @csrf
                <div class="row gy-4">
                    <div class="col-md-6">
                        <label for="invoice_number" class="form-label fw-semibold text-primary-light text-sm mb-8">No. Invoice</label>
                        <input type="text" class="form-control radius-8" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
                        @error('invoice_number')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal</label>
                        <input type="date" class="form-control radius-8" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Tipe Jasa/Sewa</label>
                        <input type="text" class="form-control radius-8" id="type" name="type" value="{{ old('type') }}" required>
                        @error('type')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="partner_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nama Mitra</label>
                        <input type="text" class="form-control radius-8" id="partner_name" name="partner_name" value="{{ old('partner_name') }}" required>
                        @error('partner_name')
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
                                    <th scope="col" width="60%">Uraian</th>
                                    <th scope="col" width="30%">Jumlah (Rp)</th>
                                    <th scope="col" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsContainer">
                                {{-- Items will be added here --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-end fw-semibold">Total</td>
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
                    <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">Simpan Invoice</button>
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

        function addItem(description = '', amount = '') {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <input type="text" class="form-control radius-8" name="items[${itemIndex}][description]" value="${description}" required placeholder="Masukkan uraian">
                </td>
                <td>
                    <input type="text" class="form-control radius-8 item-amount" name="items[${itemIndex}][amount]" value="${amount}" required placeholder="Rp 0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger-100 text-danger-600 radius-8 p-10 d-flex align-items-center justify-content-center delete-item">
                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                    </button>
                </td>
            `;
            itemsContainer.appendChild(row);

            const amountInput = row.querySelector('.item-amount');
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

            itemIndex++;
            calculateTotal();
        }

        addItemBtn.addEventListener('click', function() {
            addItem();
        });

        // Add initial item if none (or handle old input)
        @if(old('items'))
            @foreach(old('items') as $key => $item)
                addItem('{{ addslashes($item['description']) }}', '{{ $item['amount'] }}');
            @endforeach
        @else
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
