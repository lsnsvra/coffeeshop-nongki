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
     * Memproses request login dan mengirimkan OTP ke Email.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Validasi Email & Password
        $request->authenticate();

        // 2. Ambil data User yang baru saja berhasil login
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 3. Generate Kode OTP (6 Digit)
        $otp = rand(100000, 999999);

        // 4. Update data OTP User di Database dengan timezone Jakarta
        $user->update([
            'two_factor_code' => $otp,
            'two_factor_expires_at' => Carbon::now('Asia/Jakarta')->addMinutes(5),
        ]);

        // 5. Kirim Email OTP
        try {
            Mail::to($user->Email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            // Abaikan error email untuk development
        }

        // 6. Ambil ID User sebelum logout
        $id_user = $user->UserID;

        // 7. LOGOUT SEMENTARA (Agar user tidak bisa potong jalan ke dashboard)
        Auth::logout();

        // 8. Bersihkan session lama
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 9. SIMPAN ID KE SESSION BARU
        session(['2fa_user_id' => $id_user]);

        // 10. Lempar ke halaman verifikasi OTP EMAIL
        return redirect()->route('otp.email.verify.form')
            ->with('message', 'Kode verifikasi keamanan telah dikirim ke email Anda.');
    }

    /**
     * (Method ini sudah tidak dipanggil langsung dari store(),
     *  tapi tetap dipertahankan untuk digunakan setelah verifikasi OTP berhasil)
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