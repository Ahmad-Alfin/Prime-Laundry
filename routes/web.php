<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MembershipController;

// ─── Jalur Umum / Guest (Tanpa Login) ───────────────────────────────────
Route::get('/', function () {
    $serviceItems = PickupController::getServiceItems();
    $services     = array_keys($serviceItems);
    return view('pages.beranda', compact('services', 'serviceItems'));
})->name('beranda');

Route::get('/harga-layanan', fn() => view('pages.harga'))->name('harga.umum');
Route::get('/cek-status',  [StatusController::class, 'index'])->name('cek-status');
Route::post('/cek-status', [StatusController::class, 'search'])->name('cek-status.search');
Route::get('/syarat',       fn() => view('pages.syarat'))->name('syarat');
Route::get('/kontak',       fn() => view('pages.kontak'))->name('kontak');
Route::post('/kontak',     [KontakController::class, 'send'])->name('kontak.send');

// ─── Otentikasi Sosial Media (OAuth 2.0) ────────────────────────────────
Route::get('/auth/{provider}',          [AuthController::class, 'socialRedirect'])->name('auth.social');
Route::get('/auth/{provider}/callback', [AuthController::class, 'socialCallback'])->name('auth.social.callback');

// ─── Middleware Guest (Hanya untuk yang Belum Login) ───────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ─── Middleware Auth (Wajib Login & Khusus Pelanggan) ───────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/pickup',  [PickupController::class, 'store'])->name('pickup.store');
    
    // Alur Transaksi Order Laundry umum
    Route::get('/payment/{orderId}',         [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{orderId}/check',  [PaymentController::class, 'check'])->name('payment.check');
    Route::get('/payment/{orderId}/success', [PaymentController::class, 'success'])->name('payment.success');

    // 🌟 JALUR KHUSUS QRIS MEMBERSHIP PELANGGAN (DI LUAR PREFIX ADMIN) 🌟
    Route::post('/membership/register',         [MembershipController::class, 'store'])->name('membership.store');
    Route::get('/membership/payment/{id}',      [MembershipController::class, 'paymentPage'])->name('membership.payment');
    Route::get('/membership/check-status/{id}', [MembershipController::class, 'checkStatus'])->name('membership.check-status');
    Route::post('/membership/confirm/{id}',     [MembershipController::class, 'confirmPayment'])->name('membership.confirm');

    // Halaman Utama Harga milik Pelanggan biasa
    Route::get('/harga', fn() => view('pages.harga'))->name('harga');
});

// ─── Middleware Admin (Khusus Dashboard Manajemen Admin) ─────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/',                    [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/order/{id}/status',    [AdminController::class, 'updateStatus'])->name('admin.order.status');
    Route::post('/payment/{id}/confirm', [AdminController::class, 'confirmPayment'])->name('admin.payment.confirm');
    
    // 🟢 RUTE PENYELAMAT 404: Aksi Persetujuan Pendaftaran Membership oleh Admin
    Route::post('/membership/approve/{id}', [MembershipController::class, 'approve'])->name('admin.membership.approve');
});