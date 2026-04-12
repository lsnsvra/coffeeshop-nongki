<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Providers\RouteServiceProvider;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            
            // Cek apakah email sudah terdaftar
            $existingUser = User::where('email', $googleUser->email)->first();
            if ($existingUser) {
                // Update google_id untuk user yang sudah ada
                $existingUser->update(['google_id' => $googleUser->id]);
                Auth::login($existingUser);
                return redirect()->intended(RouteServiceProvider::HOME);
            }

            // Buat user baru (gunakan kolom standar Laravel: name, email, password)
            $namaUser = $googleUser->name ?? explode('@', $googleUser->email)[0];
            $newUser = User::create([
                'name' => $namaUser,           // <-- perbaiki: 'name' bukan 'Nama'
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt('123456dummy'), // <-- perbaiki: 'password' bukan 'Password'
                'role' => 'pelanggan',          // tambahkan role default jika diperlukan
            ]);

            Auth::login($newUser);
            return redirect()->intended(RouteServiceProvider::HOME);

        } catch (Exception $e) {
            // Untuk debugging, tampilkan error (hapus atau komentar setelah berhasil)
            return redirect('/login')->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}