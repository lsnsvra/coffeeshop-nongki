<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Update kolom LastUpdatedDate setiap kali user akses halaman
            // Kita pake kolom yang sudah ada di DB kamu
            Auth::user()->update([
                'LastUpdatedDate' => now()
            ]);
        }
        return $next($request);
    }
}