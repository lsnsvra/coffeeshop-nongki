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
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // Buat user baru
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
                // Update google_id jika belum ada
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
            }
            
            // Login user
            Auth::login($user);
            
            // Redirect ke dashboard
            return redirect('/dashboard');
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}