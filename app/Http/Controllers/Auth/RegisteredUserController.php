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
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:users,email'], // perhatikan: unique:users,email (lowercase)
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $now = Carbon::now();

        $user = User::create([
            'Nama' => $request->name,
            'email' => $request->email,      // kolom email (huruf kecil)
            'Email' => $request->email,      // jika ada kolom Email (huruf besar)
            'Password' => Hash::make($request->password),
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