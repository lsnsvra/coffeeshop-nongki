<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OtpController extends Controller
{
    /**
     * Helper untuk menormalisasi nomor HP ke format 62
     * Supaya user bebas ketik 08... atau 628...
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }
        if (strpos($phone, '8') === 0) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    // 1. Menampilkan form input nomor HP
    public function showPhoneForm()
    {
        return view('auth.login-phone');
    }

    // 2. Mengirim OTP via WhatsApp
    public function sendOtp(Request $request)
    {
        $request->validate(['phone_number' => 'required|string']);

        $normalizedPhone = $this->formatPhoneNumber($request->phone_number);

        // Cari user berdasarkan nomor yang sudah dinormalisasi
        $user = User::where('phone_number', $normalizedPhone)->first();

        if (!$user) {
            return back()->withErrors(['phone_number' => 'Nomor ini tidak terdaftar di sistem NONGKI.']);
        }

        $otpCode = rand(100000, 999999);

        // Update kolom sesuai database
        $user->update([
            'two_factor_code' => $otpCode,
            'two_factor_expires_at' => Carbon::now('Asia/Jakarta')->addMinutes(5)
        ]);

        // Kirim ke Fonnte
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->phone_number,
            'message' => "☕ *NONGKI COFFEE*\n\nKode OTP Anda adalah: *{$otpCode}*\n\nDemi keamanan, jangan berikan kode ini kepada siapapun. Kode berlaku selama 5 menit.",
        ]);

        if ($response->successful()) {
            session(['phone_number' => $user->phone_number]);
            return redirect()->route('otp.verify.form');
        }

        return back()->withErrors(['phone_number' => 'Gagal mengirim WhatsApp. Silakan coba lagi.']);
    }

    // 3. Menampilkan form input OTP
    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }
    
    // 3.5 Menampilkan form input OTP KHUSUS EMAIL
    public function showEmailVerifyForm()
    {
        return view('auth.verify-email-otp');
    }

    // 4. Verifikasi OTP (Bisa untuk Login Email & Login WA)
    public function verifyOtp(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        // Cek apakah user datang dari jalur Email atau WhatsApp
        $userId = session('2fa_user_id');
        $phone = session('phone_number');

        if ($userId) {
            $user = User::find($userId);
        } else {
            $user = User::where('phone_number', $phone)->first();
        }

        // Jika user tidak ditemukan atau kodenya kosong di database
        if (!$user || !$user->two_factor_code) {
            return back()->withErrors(['code' => 'Data OTP tidak valid atau sesi berakhir. Silakan kirim ulang kode.']);
        }

        $expiresAt = Carbon::parse($user->two_factor_expires_at);
        $now = Carbon::now('Asia/Jakarta');

        // Pengecekan kode dan waktu
        if ($user->two_factor_code == $request->code && $now->lessThanOrEqualTo($expiresAt)) {
            
            // Login Berhasil
            Auth::login($user);
            
            // Bersihkan data & session
            $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
            session()->forget(['2fa_user_id', 'phone_number']);

            return redirect()->intended('/dashboard'); 
        }

        return back()->withErrors(['code' => 'Kode OTP salah atau sudah kedaluwarsa.']);
    }

    // 5. Fungsi Kirim Ulang OTP via WA
    public function resend(Request $request)
    {
        $phone_number = session('phone_number');

        if (!$phone_number) {
            return redirect()->route('login.wa')->withErrors(['phone_number' => 'Sesi habis, silakan masukkan nomor kembali.']);
        }

        $user = User::where('phone_number', $phone_number)->first();

        if ($user) {
            $newOtpCode = rand(100000, 999999);
            
            $user->update([
                'two_factor_code' => $newOtpCode,
                'two_factor_expires_at' => Carbon::now('Asia/Jakarta')->addMinutes(5)
            ]);

            Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $user->phone_number,
                'message' => "☕ *NONGKI COFFEE*\n\n*[KIRIM ULANG]* Kode verifikasi baru Anda: *{$newOtpCode}*",
            ]);

            return back()->with('message', 'Kode OTP WA baru telah berhasil dikirim!');
        }

        return back()->withErrors(['code' => 'Pengguna tidak ditemukan.']);
    }
}