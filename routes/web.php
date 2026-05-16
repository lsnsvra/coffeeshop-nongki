<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\RecipeController; // TAMBAHAN: Controller buat fitur Resep
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// ============================================================
// 1. ROUTE PUBLIC (LANDING PAGE & MENU PELANGGAN)
// ============================================================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/menu', function () {
    // Menampilkan menu untuk pelanggan
    $products = \App\Models\Product::where('IsDeleted', 0)->get();
    return view('menu.index', compact('products'));
})->name('menu.index');

Route::get('/products', function () {
    return redirect()->route('menu.index');
})->name('products.index');

// ============================================================
// 2. ROUTE AUTH & GOOGLE LOGIN
// ============================================================
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php'; // Rute default bawaan Laravel (Login, Register, dll)

// ============================================================
// 3. ROUTE PELANGGAN / USER (WAJIB LOGIN)
// ============================================================
Route::middleware('auth')->group(function () {
    
    // REDIRECT DASHBOARD CERDAS
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // Cek Role (Sesuaikan jika nama field role-nya berbeda di database)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'kasir') {
            return redirect()->route('kasir.pos');
        }
        // Jika pelanggan biasa, kembalikan ke menu utama
      return view('dashboard.index');
    })->name('dashboard');

    Route::get('/manager/dashboard', function () {
        return redirect()->route('dashboard');
    })->name('manager.dashboard');

    // Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/manager/profile', function () { return redirect()->route('profile.edit'); })->name('manager.profile');

    // Halaman Fitur User
    Route::get('/keranjang', function () { return view('cart.keranjang'); })->name('keranjang');
    Route::get('/riwayat-pesanan', function () { return view('orders.riwayat-pesanan'); })->name('riwayat.pesanan');
    Route::get('/favorit', function () { return view('favorites.favorit'); })->name('favorit');
    Route::get('/profil', function () { return view('profile.profil'); })->name('profil');
    Route::get('/pengaturan', function () { return view('settings.pengaturan'); })->name('pengaturan');
    
Route::get('/pembayaran', function () { return view('payment.index'); })->name('payment.index');
    Route::get('/order-success', function () { return view('payment.success'); })->name('order.success');

    // Payment API
    Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/status/{orderId}', [PaymentController::class, 'checkStatus'])->name('payment.status');
});

// Webhook - di luar middleware (tidak perlu auth)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])
    ->name('payment.webhook')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// ============================================================
// 4. ROUTE ADMIN (HANYA ROLE ADMIN)
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin (Menggunakan Controller yang merender Data Dinamis)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    
    // ---- MANAJEMEN MENU ----
    Route::get('/menu', [ProductController::class, 'index'])->name('menu');
    Route::post('/menu/store', [ProductController::class, 'store'])->name('menu.store');
    Route::put('/menu/update/{id}', [ProductController::class, 'update'])->name('menu.update');
    Route::delete('/menu/destroy/{id}', [ProductController::class, 'destroy'])->name('menu.destroy');

    // 👇 TAMBAHAN ROUTE UNTUK FITUR RESEP (BOM) 👇
    Route::get('/menu/{id}/resep', [RecipeController::class, 'index'])->name('resep.index');
    Route::post('/menu/{id}/resep', [RecipeController::class, 'store'])->name('resep.store');
    Route::delete('/menu/{product_id}/resep/{material_id}', [RecipeController::class, 'destroy'])->name('resep.destroy');
    // 👆 END TAMBAHAN ROUTE RESEP 👆
    
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
    Route::post('/user/toggle-status/{id}', [AdminController::class, 'toggleStatus'])->name('user.toggle-status');
    Route::post('/user/update-role/{id}', [AdminController::class, 'updateRole'])->name('user.update-role');
    Route::delete('/user/destroy/{id}', [AdminController::class, 'destroy'])->name('user.destroy');

    Route::get('/stok', [StokController::class, 'index'])->name('stok');
    Route::post('/stok', [StokController::class, 'store'])->name('stok.store');
    Route::put('/stok/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::delete('/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
});

// ============================================================
// 5. ROUTE KASIR (HANYA ROLE KASIR)
// ============================================================
Route::middleware(['auth', 'role:kasir', 'track'])->prefix('kasir')->name('kasir.')->group(function () {
    // 👇 TAMBAHKAN RUTE INI UNTUK MENERIMA DATA DARI AJAX 👇
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/pos', function () { return view('kasir.pos'); })->name('pos');
    Route::get('/menu', function () { return view('kasir.menu'); })->name('menu');
    Route::get('/transaksi', function () { return view('kasir.transaksi'); })->name('transaksi');
    Route::get('/pesanan', function () { return view('kasir.pesanan'); })->name('pesanan');
});

// ============================================================
// 6. ROUTE OTP (VERIFIKASI & 2FA)
// ============================================================
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::get('/verify-email-otp', [OtpController::class, 'showEmailVerifyForm'])->name('otp.email.verify.form');
Route::post('/2fa/verify', [OtpController::class, 'verifyOtp'])->name('2fa.store');
Route::post('/2fa/resend', [OtpController::class, 'resend'])->name('2fa.resend');

Route::middleware('guest')->group(function () {
    Route::get('/login-wa', [OtpController::class, 'showPhoneForm'])->name('login.wa');
    Route::post('/login-wa', [OtpController::class, 'sendOtp'])->name('otp.send');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/otp', function () { return view('auth.otp'); })->name('otp.form');
    Route::post('/otp/verify', function () { return redirect()->route('dashboard')->with('success', 'OTP berhasil diverifikasi.'); })->name('otp.verify');
    Route::get('/otp/resend', function () { return back()->with('status', 'Kode OTP baru telah dikirim.'); })->name('otp.resend');
});

// ============================================================
// 7. ROUTE OPTIMASI (CLEAR CACHE)
// ============================================================
Route::get('/optimize', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return "Konfigurasi berhasil diperbarui!";
});

Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache cleared and Config is fresh!";
});