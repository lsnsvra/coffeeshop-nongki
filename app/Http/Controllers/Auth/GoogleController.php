<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;

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
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
                Auth::login($existingUser);
                return redirect()->intended(RouteServiceProvider::HOME);
            }

            // Buat user baru - sesuaikan dengan struktur database
            $namaUser = $googleUser->name ?? explode('@', $googleUser->email)[0];
            $now = Carbon::now();
            
            $newUser = User::create([
                'Nama' => $namaUser,                    // kolom Nama
                'email' => $googleUser->email,          // kolom email lowercase
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'Password' => bcrypt(uniqid()),         // kolom Password
                'Role' => 'pelanggan',
                'Status' => 1,
                'IsDeleted' => 0,
                'CreatedDate' => $now,
                'LastUpdatedDate' => $now,
            ]);

            Auth::login($newUser);
            return redirect()->intended(RouteServiceProvider::HOME);

        } catch (Exception $e) {
            // Tampilkan error untuk debugging
            dd($e->getMessage());
        }
    }
}