<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/logo/logo_koperasi.png') }}" alt="Koperasi Angkasa Jaya" class="light-logo">
            <img src="{{ asset('assets/logo/logo_koperasi.png') }}" alt="Koperasi Angkasa Jaya" class="dark-logo">
            <img src="{{ asset('assets/logo/logo_koperasi.png') }}" alt="Koperasi Angkasa Jaya" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            @if(auth()->user()->hasRole('super-admin'))
                @include('layouts.sidebar.superadmin')
            @elseif(auth()->user()->hasRole('anggota'))
                @include('layouts.sidebar.anggota')
            @elseif(auth()->user()->hasRole('spv'))
                @include('layouts.sidebar.spv')
            @elseif(auth()->user()->hasRole('admin-simpan-pinjam'))
                @include('layouts.sidebar.admin-simpan-pinjam')
            @elseif(auth()->user()->hasRole('admin-mini-market'))
                @include('layouts.sidebar.admin-mini-market')
            @endif
        </ul>
    </div>
</aside>
