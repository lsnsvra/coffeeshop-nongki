<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
// 1. Tambahkan pemanggilan GoogleController di sini
use App\Http\Controllers\Auth\GoogleController;
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
// ROUTE MENU
// ============================================================
Route::get('/menu', [ProductController::class, 'index'])->name('menu.index');

// ============================================================
// ROUTE PRODUCT
// ============================================================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ============================================================
// ROUTE LOGIN GOOGLE
// ============================================================
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ============================================================
// ROUTE DASHBOARD (HANYA AUTH, TANPA VERIFIED)
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
// ROUTE KERANJANG
// ============================================================
Route::get('/keranjang', function () {
    return view('cart.keranjang');
})->name('keranjang');

// ============================================================
// ROUTE RIWAYAT PESANAN
// ============================================================
Route::get('/riwayat-pesanan', function () {
    return view('orders.riwayat-pesanan');
})->name('riwayat.pesanan');

// ============================================================
// ROUTE FAVORIT
// ============================================================
Route::get('/favorit', function () {
    return view('favorites.favorit');
})->name('favorit');

// ============================================================
// ROUTE PROFIL
// ============================================================
Route::get('/profil', function () {
    return view('profile.profil');
})->name('profil');

// ============================================================
// ROUTE PENGATURAN
// ============================================================
Route::get('/pengaturan', function () {
    return view('settings.pengaturan');
})->name('pengaturan');

// ============================================================
// ROUTE PEMBAYARAN & ORDER SUCCESS
// ============================================================
Route::get('/pembayaran', function () {
    return view('payment.index');
})->name('payment.index');

Route::get('/order-success', function () {
    return view('payment.success');
})->name('order.success');

// ============================================================
// ROUTE AUTH (LARAVEL BAWAAN)
// ============================================================
require __DIR__.'/auth.php';

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('add.to.cart');