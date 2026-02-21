<li class="sidebar-menu-group-title">Menu Utama</li>

<li>
    <a href="{{ route('staff-keuangan.dashboard') }}" class="{{ request()->routeIs('staff-keuangan.dashboard') ? 'active' : '' }}">
        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
        <span>Dashboard</span>
    </a>
</li>

<li>
    <a href="{{ route('staff-keuangan.invoice.index') }}" class="{{ request()->routeIs('staff-keuangan.invoice.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:invoice-text-outline" class="menu-icon"></iconify-icon>
        <span>Manajemen Invoice</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Pengaturan</li>

<li>
    <a href="{{ route('staff-keuangan.settings.invoice.index') }}" class="{{ request()->routeIs('staff-keuangan.settings.invoice.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:cog-outline" class="menu-icon"></iconify-icon>
        <span>Pengaturan Invoice</span>
    </a>
</li>
