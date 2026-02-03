<!-- Admin Simpan Pinjam Sidebar Menu -->
<li class="sidebar-menu-group-title">Menu Utama</li>

<li>
    <a href="{{ route('admin-sp.dashboard') }}" class="{{ request()->routeIs('admin-sp.dashboard') ? 'active' : '' }}">
        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Manajemen</li>

<li>
    <a href="{{ route('admin-sp.pengajuan.index') }}" class="{{ request()->routeIs('admin-sp.pengajuan.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:file-document-check-outline" class="menu-icon"></iconify-icon>
        <span>Pengajuan Pinjaman</span>
    </a>
</li>

<li>
    <a href="{{ route('admin-sp.pinjaman.index') }}" class="{{ request()->routeIs('admin-sp.pinjaman.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:hand-coin-outline" class="menu-icon"></iconify-icon>
        <span>Data Pinjaman</span>
    </a>
</li>

<li>
    <a href="{{ route('admin-sp.angsuran.index') }}" class="{{ request()->routeIs('admin-sp.angsuran.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:clipboard-text-clock-outline" class="menu-icon"></iconify-icon>
        <span>Riwayat Angsuran</span>
    </a>
</li>
