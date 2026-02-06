@extends('layouts.app')

@section('title', 'Pengaturan Invoice')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Pengaturan Invoice</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-mini-market.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
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

    <div class="card h-100 p-0 section-bg shadow-none text-start radius-16">
        <div class="card-body p-24">
            <form action="{{ route('admin-mini-market.settings.invoice.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row gy-4">
                    <div class="col-12">
                        <label for="company_logo" class="form-label fw-semibold text-primary-light text-sm mb-8">Logo Perusahaan</label>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url('{{ $setting->logo_url ?? asset('assets/logo/logo_koperasi.png') }}'); width: 100%; height: 100%; background-size: cover; background-repeat: no-repeat; background-position: center;">
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
                        <label for="company_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nama Perusahaan/Koperasi</label>
                        <input type="text" class="form-control radius-8" id="company_name" name="company_name" value="{{ old('company_name', $setting->company_name ?? 'Koperasi Angkasa Jaya') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="company_email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                        <input type="email" class="form-control radius-8" id="company_email" name="company_email" value="{{ old('company_email', $setting->company_email ?? 'koperasi@angkasajaya.com') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="company_phone" class="form-label fw-semibold text-primary-light text-sm mb-8">Nomor Telepon</label>
                        <input type="text" class="form-control radius-8" id="company_phone" name="company_phone" value="{{ old('company_phone', $setting->company_phone ?? '(021) 1234-5678') }}">
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
