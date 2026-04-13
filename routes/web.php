<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/menu', [ProductController::class, 'index'])->name('menu.index');

// ============================================================
// ROUTE LANDING PAGE (UNTUK GUEST)
// ============================================================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// ============================================================
// ROUTE BERANDA UNTUK USER YANG SUDAH LOGIN
// ============================================================
Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

// ============================================================
// ROUTE PRODUCT
// ============================================================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ============================================================
// ROUTE UNTUK LOGIN GOOGLE
// ============================================================
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ============================================================
// ROUTE DASHBOARD (ADMIN)
// ============================================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/manager/dashboard', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('manager.dashboard');

// ============================================================
// ROUTE PROFILE (AUTH)
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