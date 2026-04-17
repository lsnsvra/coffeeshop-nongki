<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================
// ROUTE LANDING PAGE
// ============================================================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

// ============================================================
// ROUTE MENU & PRODUCT
// ============================================================
Route::get('/menu', [ProductController::class, 'index'])->name('menu.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ============================================================
// ROUTE LOGIN GOOGLE
// ============================================================
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ============================================================
// ROUTE DASHBOARD (HANYA AUTH)
// ============================================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::get('/manager/dashboard', function () {
    return redirect()->route('dashboard');
})->middleware(['auth'])->name('manager.dashboard');

// ============================================================
// ROUTE PROFILE
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/manager/profile', function () {
        return redirect()->route('profile.edit');
    })->name('manager.profile');
});

// ============================================================
// ROUTE BELANJA & PESANAN (BISA DIAKSES USER)
// ============================================================
Route::get('/keranjang', function () { return view('cart.keranjang'); })->name('keranjang');
Route::get('/riwayat-pesanan', function () { return view('orders.riwayat-pesanan'); })->name('riwayat.pesanan');
Route::get('/favorit', function () { return view('favorites.favorit'); })->name('favorit');
Route::get('/profil', function () { return view('profile.profil'); })->name('profil');
Route::get('/pengaturan', function () { return view('settings.pengaturan'); })->name('pengaturan');

// ============================================================
// ROUTE PEMBAYARAN & ORDER SUCCESS
// ============================================================
Route::get('/pembayaran', function () { return view('payment.index'); })->name('payment.index');
Route::get('/order-success', function () { return view('payment.success'); })->name('order.success');

/// ============================================================
// ROUTE OTP (WHATSAPP & EMAIL 2FA)
// ============================================================
// Route verifikasi dilepas dari 'guest' agar bisa diakses saat proses login email
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::get('/verify-email-otp', [OtpController::class, 'showEmailVerifyForm'])->name('otp.email.verify.form'); 
Route::post('/2fa/verify', [OtpController::class, 'verifyOtp'])->name('2fa.store');
Route::post('/2fa/resend', [OtpController::class, 'resend'])->name('2fa.resend');

Route::middleware('guest')->group(function () {
    // Alur khusus login WhatsApp
    Route::get('/login-wa', [OtpController::class, 'showPhoneForm'])->name('login.wa');
    Route::post('/login-wa', [OtpController::class, 'sendOtp'])->name('otp.send');
});

// ============================================================
// ROUTE AUTH (LARAVEL BAWAAN)
// ============================================================
require __DIR__.'/auth.php';