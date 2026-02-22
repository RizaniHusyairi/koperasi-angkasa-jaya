@extends('layouts.app')

@section('title', 'Pengaturan Invoice')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Pengaturan Invoice</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('staff-keuangan.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Pengaturan</li>
            <li>-</li>
            <li class="fw-medium">Invoice</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card h-100 p-0 section-bg shadow-none text-start radius-16">
        <div class="card-body p-24">
            <form action="{{ route('staff-keuangan.settings.invoice.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row gy-4">
                    <div class="col-12">
                        <label for="company_logo" class="form-label fw-semibold text-primary-light text-sm mb-8">Logo Perusahaan</label>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url('{{ $setting && $setting->company_logo ? asset('storage/' . $setting->company_logo) : asset('assets/logo/logo_koperasi.png') }}'); width: 100%; height: 100%; background-size: contain; background-repeat: no-repeat; background-position: center;">
                                    </div>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type='file' id="imageUpload" name="company_logo" accept=".png, .jpg, .jpeg" hidden />
                                <label for="imageUpload" class="btn btn-primary-600 radius-8 px-20 py-11">Upload Logo</label>
                                <p class="text-secondary-light text-xs mt-2">Dianjurkan PNG Transparan. Max 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="company_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nama Perusahaan/Koperasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control radius-8" id="company_name" name="company_name" value="{{ old('company_name', $setting->company_name ?? 'Koperasi Angkasa Jaya') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="company_email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                        <input type="email" class="form-control radius-8" id="company_email" name="company_email" value="{{ old('company_email', $setting->company_email ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="company_phone" class="form-label fw-semibold text-primary-light text-sm mb-8">Nomor Telepon</label>
                        <input type="text" class="form-control radius-8" id="company_phone" name="company_phone" value="{{ old('company_phone', $setting->company_phone ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="bank_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nama Bank</label>
                        <input type="text" class="form-control radius-8" id="bank_name" name="bank_name" value="{{ old('bank_name', $setting->bank_name ?? 'Bank BCA') }}" placeholder="Contoh: Bank BCA">
                    </div>

                    <div class="col-md-6">
                        <label for="bank_account" class="form-label fw-semibold text-primary-light text-sm mb-8">Nomor Rekening</label>
                        <input type="text" class="form-control radius-8" id="bank_account" name="bank_account" value="{{ old('bank_account', $setting->bank_account ?? '1234567890 a/n Koperasi Angkasa Jaya') }}" placeholder="Contoh: 1234567890 a/n Koperasi Angkasa Jaya">
                    </div>

                    <div class="col-md-12">
                        <label for="company_address" class="form-label fw-semibold text-primary-light text-sm mb-8">Alamat Lengkap</label>
                        <textarea class="form-control radius-8" id="company_address" name="company_address" rows="3">{{ old('company_address', $setting->company_address ?? 'Jalan Raya Angkasa No. 123, Jakarta') }}</textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').style.backgroundImage = 'url('+e.target.result +')';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById('imageUpload').addEventListener('change', function() {
        readURL(this);
    });
</script>
@endsection
