<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

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
Route::get('/', [ProductController::class, 'home'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/manager/dashboard', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('manager.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/manager/profile', function () {
        return redirect()->route('profile.edit');
    })->name('manager.profile');
});

// Keranjang
Route::get('/keranjang', function () {
    return view('cart.keranjang');
})->name('keranjang');

// Riwayat Pesanan
Route::get('/riwayat-pesanan', function () {
    return view('orders.riwayat-pesanan');
})->name('riwayat.pesanan');

// Favorit
Route::get('/favorit', function () {
    return view('favorites.favorit');
})->name('favorit');

// Profil Saya
Route::get('/profil', function () {
    return view('profile.profil');
})->name('profil');

// Pengaturan
Route::get('/pengaturan', function () {
    return view('settings.pengaturan');
})->name('pengaturan');

// Pembayaran
Route::get('/pembayaran', function () {
    return view('payment.index');
})->name('payment.index');

Route::get('/order-success', function () {
    return view('payment.success');
})->name('order.success');

// ============================================================
// Contoh jika pakai controller (opsional):
// Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
// ============================================================
require __DIR__.'/auth.php';