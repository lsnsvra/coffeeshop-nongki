<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Helper untuk menormalisasi nomor HP ke format 62 sebelum simpan ke DB
     */
    private function formatPhone($phone)
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

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
        ]);

        $now = Carbon::now();

        $user = User::create([
            'Nama' => $request->name,
            'email' => $request->email,      
            'Email' => $request->email,      
            'Password' => Hash::make($request->password),
            // PENTING: Gunakan fungsi formatPhone di sini
            'phone_number' => $this->formatPhone($request->phone_number),
            'Role' => 'pelanggan',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => $now,
            'LastUpdatedDate' => $now,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}