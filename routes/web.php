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
// ROUTE BELANJA & PESANAN (USER)
// ============================================================
Route::get('/keranjang', function () {
    return view('cart.keranjang');
})->name('keranjang');

Route::get('/riwayat-pesanan', function () {
    return view('orders.riwayat-pesanan');
})->name('riwayat.pesanan');

Route::get('/favorit', function () {
    return view('favorites.favorit');
})->name('favorit');

Route::get('/profil', function () {
    return view('profile.profil');
})->name('profil');

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
// ROUTE OTP (WHATSAPP & EMAIL 2FA)
// ============================================================
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::get('/verify-email-otp', [OtpController::class, 'showEmailVerifyForm'])->name('otp.email.verify.form');
Route::post('/2fa/verify', [OtpController::class, 'verifyOtp'])->name('2fa.store');
Route::post('/2fa/resend', [OtpController::class, 'resend'])->name('2fa.resend');

Route::middleware('guest')->group(function () {
    Route::get('/login-wa', [OtpController::class, 'showPhoneForm'])->name('login.wa');
    Route::post('/login-wa', [OtpController::class, 'sendOtp'])->name('otp.send');
});

// ============================================================
// ROUTE OTP (VERIFIKASI 6 DIGIT - HALAMAN AUTH)
// ============================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/otp', function () {
        return view('auth.otp');
    })->name('otp.form');

    Route::post('/otp/verify', function () {
        return redirect()->route('dashboard')->with('success', 'OTP berhasil diverifikasi.');
    })->name('otp.verify');

    Route::get('/otp/resend', function () {
        return back()->with('status', 'Kode OTP baru telah dikirim.');
    })->name('otp.resend');
});

// ============================================================
// ROUTE ADMIN (HANYA ROLE ADMIN)
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('laporan');

    Route::get('/laporan/harian', function () {
        return redirect()->route('admin.laporan', ['filter' => 'harian']);
    })->name('laporan.harian');

    Route::get('/stok', function () {
        return view('admin.stok');
    })->name('stok');

    Route::get('/menu', function () {
        return view('admin.menu');
    })->name('menu');

    Route::get('/pengguna', function () {
        return view('admin.pengguna');
    })->name('pengguna');
});

// ============================================================
// ROUTE KASIR (HANYA ROLE KASIR)
// ============================================================
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/pos', function () {
        return view('kasir.pos');
    })->name('pos');

    Route::get('/menu', function () {
        return view('kasir.menu');
    })->name('menu');

    Route::get('/transaksi', function () {
        return view('kasir.transaksi');
    })->name('transaksi');

    Route::get('/pesanan', function () {
        return view('kasir.pesanan');
    })->name('pesanan');
});

// ============================================================
// ROUTE AUTH (LARAVEL BAWAAN - REGISTER, LOGIN, DLL)
// ============================================================
require __DIR__.'/auth.php';