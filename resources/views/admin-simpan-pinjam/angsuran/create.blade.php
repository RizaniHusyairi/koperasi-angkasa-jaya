@extends('layouts.app')

@section('title', 'Catat Angsuran')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Catat Angsuran Baru</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-sp.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin-sp.angsuran.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Angsuran
                </a>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin-sp.angsuran.store') }}" method="POST">
                @csrf
                <div class="row gy-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Pilih Pinjaman</label>
                        <select name="pinjaman_id" id="pinjaman_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Anggota / Pinjaman --</option>
                            @foreach($pinjaman as $p)
                                <option value="{{ $p->id }}" data-sisa="{{ $p->sisa_pinjaman }}" data-angsuran="{{ $p->angsuran_bulanan }}">
                                    {{ $p->anggota->user->name }} ({{ $p->anggota->nomor_anggota }}) - Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row gy-4 mt-4">
                     <div class="col-md-6">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Angsuran Pokok + Bunga (Rp)</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" placeholder="Masukkan jumlah bayar" required min="1">
                        <small class="text-secondary-light">Estimasi angsuran bulanan: <span id="estimasi_angsuran" class="fw-bold">-</span></small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Denda (Jika ada) (Rp)</label>
                        <input type="number" name="denda" class="form-control" placeholder="0" value="0" min="0">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Pembayaran transfer bank..."></textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary-600">Simpan Pembayaran</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#pinjaman_id').change(function() {
        let option = $(this).find(':selected');
        let angsuran = option.data('angsuran');
        let sisa = option.data('sisa');

        if(angsuran) {
            // Round up to nearest hundred if needed, or just show raw
            let formattedAngsuran = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angsuran);
            $('#estimasi_angsuran').text(formattedAngsuran);
            $('#jumlah_bayar').val(Math.round(angsuran)); // Suggest payment amount
            $('#jumlah_bayar').attr('max', sisa);
        } else {
            $('#estimasi_angsuran').text('-');
            $('#jumlah_bayar').val('');
        }
    });
</script>
@endpush
