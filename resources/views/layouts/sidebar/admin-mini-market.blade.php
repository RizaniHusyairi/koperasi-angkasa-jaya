<li class="sidebar-menu-group-title">Menu</li>
<li>
    <a href="{{ route('admin-mini-market.dashboard') }}" class="{{ request()->routeIs('admin-mini-market.dashboard') ? 'active-page' : '' }}">
        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('admin-mini-market.products.index') }}" class="{{ request()->routeIs('admin-mini-market.products.*') ? 'active-page' : '' }}">
        <iconify-icon icon="mdi:package-variant-closed" class="menu-icon"></iconify-icon>
        <span>Produk</span>
    </a>
</li>
<li>
    <a href="{{ route('admin-mini-market.orders.index') }}" class="{{ request()->routeIs('admin-mini-market.orders.*') ? 'active-page' : '' }}">
        <iconify-icon icon="mdi:cart-outline" class="menu-icon"></iconify-icon>
        <span>Pesanan</span>
    </a>
</li>
<li>
    <a href="{{ route('admin-mini-market.anggota.index') }}" class="{{ request()->routeIs('admin-mini-market.anggota.*') ? 'active-page' : '' }}">
        <iconify-icon icon="mdi:account-group-outline" class="menu-icon"></iconify-icon>
        <span>Data Anggota</span>
    </a>
</li>
<li class="sidebar-menu-group-title">Pengaturan</li>
<li>
    <a href="{{ route('admin-mini-market.settings.invoice.index') }}" class="{{ request()->routeIs('admin-mini-market.settings.invoice.*') ? 'active-page' : '' }}">
        <iconify-icon icon="mdi:file-document-edit-outline" class="menu-icon"></iconify-icon>
        <span>Invoice</span>
    </a>
</li>
