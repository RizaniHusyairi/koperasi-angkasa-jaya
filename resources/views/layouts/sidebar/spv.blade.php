<!-- SPV Sidebar Menu -->
<li class="sidebar-menu-group-title">Menu Utama</li>

<li>
    <a href="{{ route('spv.dashboard') }}" class="{{ request()->routeIs('spv.dashboard') ? 'active' : '' }}">
        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Manajemen</li>

<li>
    <a href="{{ route('spv.pegawai.index') }}" class="{{ request()->routeIs('spv.pegawai.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:account-tie-outline" class="menu-icon"></iconify-icon>
        <span>Manajemen Pegawai</span>
    </a>
</li>
