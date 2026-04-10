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
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    $existingUser->update(['google_id' => $googleUser->id]);
                    Auth::login($existingUser);
                    return redirect('/')->intended(RouteServiceProvider::HOME);
                }

                
                // 1. Ambil nama dari Google (Gunakan ->name, bukan ->getName)
                $namaUser = $googleUser->name;
                
                // 2. Rencana Cadangan: Jika nama kosong, gunakan bagian depan email
                if (empty($namaUser)) {
                    $namaUser = explode('@', $googleUser->email)[0]; 
                }

                // 3. Simpan ke database
                $newUser = User::create([
                    'Nama' => $namaUser, 
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'Password' => bcrypt('123456dummy') 
                ]);

                // --- AKHIR BAGIAN YANG DIPERBAIKI ---

                Auth::login($newUser);
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        } catch (Exception $e) {
            // Kita gunakan fungsi dd() untuk menampilkan error aslinya ke layar
            // HAPUS ATAU COMMENT BLOK INI NANTI JIKA SUDAH BERHASIL
            dd([
                'pesan_error' => $e->getMessage(),
                'baris' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            // return redirect('/login')->with('error', 'Gagal login menggunakan Google.');
        }
    }
}