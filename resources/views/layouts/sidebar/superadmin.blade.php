<!-- Super Admin Sidebar Menu -->
<li class="sidebar-menu-group-title">Menu Utama</li>

<li>
    <a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Manajemen</li>

<li>
    <a href="{{ route('superadmin.users.index') }}" class="{{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
        <span>Pengguna</span>
    </a>
</li>

<li>
    <a href="{{ route('superadmin.anggota.index') }}" class="{{ request()->routeIs('superadmin.anggota.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:account-group-outline" class="menu-icon"></iconify-icon>
        <span>Anggota Koperasi</span>
    </a>
</li>
