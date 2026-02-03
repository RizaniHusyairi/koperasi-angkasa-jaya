<!-- Anggota Sidebar Menu -->
<li class="sidebar-menu-group-title">Menu Utama</li>

<li>
    <a href="{{ route('anggota.dashboard') }}" class="{{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Simpanan</li>

<li>
    <a href="{{ route('anggota.simpanan.pokok') }}" class="{{ request()->routeIs('anggota.simpanan.pokok') ? 'active' : '' }}">
        <iconify-icon icon="mdi:piggy-bank-outline" class="menu-icon"></iconify-icon>
        <span>Simpanan Pokok</span>
    </a>
</li>

<li>
    <a href="{{ route('anggota.simpanan.wajib') }}" class="{{ request()->routeIs('anggota.simpanan.wajib') ? 'active' : '' }}">
        <iconify-icon icon="mdi:cash-multiple" class="menu-icon"></iconify-icon>
        <span>Simpanan Wajib</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Pinjaman & Tabungan</li>

<li>
    <a href="{{ route('anggota.pinjaman.index') }}" class="{{ request()->routeIs('anggota.pinjaman.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:hand-coin-outline" class="menu-icon"></iconify-icon>
        <span>Sisa Pinjaman</span>
    </a>
</li>

<li>
    <a href="{{ route('anggota.tabungan.index') }}" class="{{ request()->routeIs('anggota.tabungan.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:wallet-outline" class="menu-icon"></iconify-icon>
        <span>Tabungan</span>
    </a>
</li>

<li>
    <a href="{{ route('anggota.pengajuan.index') }}" class="{{ request()->routeIs('anggota.pengajuan.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:file-document-edit-outline" class="menu-icon"></iconify-icon>
        <span>Pengajuan Pinjaman</span>
    </a>
</li>

<li class="sidebar-menu-group-title">Layanan</li>

<li>
    <a href="{{ route('anggota.mini-market.index') }}" class="{{ request()->routeIs('anggota.mini-market.*') ? 'active' : '' }}">
        <iconify-icon icon="mdi:cart-variant" class="menu-icon"></iconify-icon>
        <span>Belanja Kebutuhan Pokok</span>
    </a>
</li>
