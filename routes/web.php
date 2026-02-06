<?php

use Illuminate\Support\Facades\Route;

// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUser;
use App\Http\Controllers\SuperAdmin\AnggotaController as SuperAdminAnggota;

// Anggota Controllers
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboard;
use App\Http\Controllers\Anggota\SimpananController as AnggotaSimpanan;
use App\Http\Controllers\Anggota\PinjamanController as AnggotaPinjaman;
use App\Http\Controllers\Anggota\TabunganController as AnggotaTabungan;
use App\Http\Controllers\Anggota\PengajuanController as AnggotaPengajuan;
use App\Http\Controllers\Anggota\ProfileController as AnggotaProfile;

// SPV Controllers
use App\Http\Controllers\SPV\DashboardController as SPVDashboard;
use App\Http\Controllers\SPV\PegawaiController as SPVPegawai;
use App\Http\Controllers\SPV\ProfileController as SPVProfile;

// Admin Simpan Pinjam Controllers
use App\Http\Controllers\AdminSimpanPinjam\DashboardController as AdminSPDashboard;
use App\Http\Controllers\AdminSimpanPinjam\PengajuanController as AdminSPPengajuan;
use App\Http\Controllers\AdminSimpanPinjam\PinjamanController as AdminSPPinjaman;
use App\Http\Controllers\AdminSimpanPinjam\ProfileController as AdminSPProfile;

// Admin Mini Market Controllers
use App\Http\Controllers\AdminMiniMarket\DashboardController as AdminMiniMarketDashboard;
use App\Http\Controllers\AdminMiniMarket\ProductController as AdminMiniMarketProduct;
use App\Http\Controllers\AdminMiniMarket\OrderController as AdminMiniMarketOrder;
use App\Http\Controllers\AdminMiniMarket\ProfileController as AdminMiniMarketProfile;

// Anggota Mini Market Controller
use App\Http\Controllers\Anggota\MiniMarketController as AnggotaMiniMarket;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect after login based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('super-admin')) {
        return redirect()->route('superadmin.dashboard');
    } elseif ($user->hasRole('anggota')) {
        return redirect()->route('anggota.dashboard');
    } elseif ($user->hasRole('spv')) {
        return redirect()->route('spv.dashboard');
    } elseif ($user->hasRole('admin-simpan-pinjam')) {
        return redirect()->route('admin-sp.dashboard');
    } elseif ($user->hasRole('admin-mini-market')) {
        return redirect()->route('admin-mini-market.dashboard');
    }
    
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Super Admin Routes
Route::middleware(['auth', 'role:super-admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', SuperAdminUser::class);
    Route::resource('anggota', SuperAdminAnggota::class);
});

// Anggota Routes
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [AnggotaDashboard::class, 'index'])->name('dashboard');
    Route::get('/simpanan-pokok', [AnggotaSimpanan::class, 'pokok'])->name('simpanan.pokok');
    Route::get('/simpanan-wajib', [AnggotaSimpanan::class, 'wajib'])->name('simpanan.wajib');
    Route::get('/pinjaman', [AnggotaPinjaman::class, 'index'])->name('pinjaman.index');
    Route::get('/tabungan', [AnggotaTabungan::class, 'index'])->name('tabungan.index');
    Route::resource('pengajuan', AnggotaPengajuan::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/pengaturan', [AnggotaProfile::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profile', [AnggotaProfile::class, 'updateProfile'])->name('pengaturan.profile');
    Route::put('/pengaturan/password', [AnggotaProfile::class, 'updatePassword'])->name('pengaturan.password');

    // Mini Market
    Route::get('/mini-market', [AnggotaMiniMarket::class, 'index'])->name('mini-market.index');
    Route::get('/mini-market/cart', [AnggotaMiniMarket::class, 'cart'])->name('mini-market.cart');
    Route::post('/mini-market/cart', [AnggotaMiniMarket::class, 'addToCart'])->name('mini-market.cart.add');
    Route::delete('/mini-market/cart/{id}', [AnggotaMiniMarket::class, 'removeFromCart'])->name('mini-market.cart.remove');
    Route::post('/mini-market/checkout', [AnggotaMiniMarket::class, 'checkout'])->name('mini-market.checkout');
    Route::get('/mini-market/orders', [AnggotaMiniMarket::class, 'orders'])->name('mini-market.orders');
});

// SPV Routes
Route::middleware(['auth', 'role:spv'])->prefix('spv')->name('spv.')->group(function () {
    Route::get('/dashboard', [SPVDashboard::class, 'index'])->name('dashboard');
    Route::resource('pegawai', SPVPegawai::class);
    Route::get('/pengaturan', [SPVProfile::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profile', [SPVProfile::class, 'updateProfile'])->name('pengaturan.profile');
    Route::put('/pengaturan/password', [SPVProfile::class, 'updatePassword'])->name('pengaturan.password');
});

// Admin Simpan Pinjam Routes
Route::middleware(['auth', 'role:admin-simpan-pinjam'])->prefix('admin-sp')->name('admin-sp.')->group(function () {
    Route::get('/dashboard', [AdminSPDashboard::class, 'index'])->name('dashboard');
    Route::get('/pengajuan', [AdminSPPengajuan::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [AdminSPPengajuan::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/approve', [AdminSPPengajuan::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{pengajuan}/reject', [AdminSPPengajuan::class, 'reject'])->name('pengajuan.reject');
    Route::get('/pinjaman', [AdminSPPinjaman::class, 'index'])->name('pinjaman.index');
    Route::get('/pinjaman/{pinjaman}', [AdminSPPinjaman::class, 'show'])->name('pinjaman.show');
    Route::get('/pengaturan', [AdminSPProfile::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profile', [AdminSPProfile::class, 'updateProfile'])->name('pengaturan.profile');
    Route::put('/pengaturan/password', [AdminSPProfile::class, 'updatePassword'])->name('pengaturan.password');
    Route::resource('angsuran', \App\Http\Controllers\AdminSimpanPinjam\AngsuranController::class)->only(['index', 'create', 'store']);
});

// Admin Mini Market Routes
Route::middleware(['auth', 'role:admin-mini-market'])->prefix('admin-mini-market')->name('admin-mini-market.')->group(function () {
    Route::get('/dashboard', [AdminMiniMarketDashboard::class, 'index'])->name('dashboard');
    Route::resource('products', AdminMiniMarketProduct::class);
    Route::resource('orders', AdminMiniMarketOrder::class);
    Route::get('orders/{order}/print', [AdminMiniMarketOrder::class, 'print'])->name('orders.print');
    // Member list with order history
    Route::get('/anggota', [AdminMiniMarketOrder::class, 'anggota'])->name('anggota.index');
    Route::get('/anggota/{anggota}', [AdminMiniMarketOrder::class, 'anggotaShow'])->name('anggota.show');

    // Member list with order history
    Route::get('/anggota', [AdminMiniMarketOrder::class, 'anggota'])->name('anggota.index');
    Route::get('/anggota/{anggota}', [AdminMiniMarketOrder::class, 'anggotaShow'])->name('anggota.show');

    // Settings
    Route::get('/settings/invoice', [App\Http\Controllers\AdminMiniMarket\InvoiceSettingController::class, 'index'])->name('settings.invoice.index');
    Route::put('/settings/invoice', [App\Http\Controllers\AdminMiniMarket\InvoiceSettingController::class, 'update'])->name('settings.invoice.update');

    // Profile Settings
    Route::get('/pengaturan', [AdminMiniMarketProfile::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profile', [AdminMiniMarketProfile::class, 'updateProfile'])->name('pengaturan.profile');
    Route::put('/pengaturan/password', [AdminMiniMarketProfile::class, 'updatePassword'])->name('pengaturan.password');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

