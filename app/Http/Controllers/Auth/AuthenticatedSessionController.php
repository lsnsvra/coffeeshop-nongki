<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Mail\SendOtpMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman form login biasa (Email & Password).
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses request login.
     * - Admin & Kasir: langsung redirect tanpa OTP.
     * - User biasa: dikirim OTP dan diarahkan ke halaman verifikasi.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Validasi Email & Password (otomatis login)
        $request->authenticate();
        $request->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. Jika role adalah admin atau kasir, langsung redirect tanpa OTP
        if (in_array($user->Role, ['admin', 'kasir'])) {
            return $this->authenticated($request, $user);
        }

        // 3. Untuk role selain admin/kasir (misal: user/pelanggan), lanjutkan proses OTP
        $otp = rand(100000, 999999);

        $user->update([
            'two_factor_code'       => $otp,
            'two_factor_expires_at' => Carbon::now('Asia/Jakarta')->addMinutes(5),
        ]);

        // 4. Kirim Email OTP
        try {
            Mail::to($user->Email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            // Abaikan error email untuk development
        }

        // 5. Ambil ID User sebelum logout
        $id_user = $user->UserID;

        // 6. LOGOUT SEMENTARA (agar user tidak bisa langsung ke dashboard)
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 7. Simpan ID user ke session baru untuk verifikasi OTP
        session(['2fa_user_id' => $id_user]);

        // 8. Arahkan ke halaman verifikasi OTP email
        return redirect()->route('otp.email.verify.form')
            ->with('message', 'Kode verifikasi keamanan telah dikirim ke email Anda.');
    }

    /**
     * Redirect setelah autentikasi berhasil berdasarkan role.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->Role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->Role === 'kasir') {
            return redirect()->route('kasir.pos');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Memproses Logout user dari sistem.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}