<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            // 1. Ambil data dari Google (Gunakan nama $googleUser agar tidak bentrok)
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // 2. Cari user di database berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // 3. Buat user baru jika tidak ditemukan
                $user = User::create([
                    'Nama' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'Password' => bcrypt(Str::random(16)),
                    'Role' => 'pelanggan',
                    'Status' => 1,
                    'IsDeleted' => 0,
                    'CreatedDate' => Carbon::now(),
                    'LastUpdatedDate' => Carbon::now(),
                ]);
            } else {
                // 4. Update google_id jika user sudah ada tapi belum punya link google
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
            }
            
            // 5. Login user
            Auth::login($user);
            
            request()->session()->put('user_id', $user->id);
            request()->session()->save();
            
            // 6. Redirect ke dashboard
            return redirect('/dashboard');
            
        } catch (\Exception $e) {
            // Tampilkan error jika terjadi masalah
            dd("Terjadi kesalahan: " . $e->getMessage()); 
        }
    }
}