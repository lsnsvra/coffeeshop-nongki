<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Pastikan ini pakai huruf 'I' besar, bukan 'T'
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if (!$user->role || !in_array($user->role, $roles)) {
        return redirect()->route('home')
            ->with('error', 'Unauthorized Access');
    }

    return $next($request);
}

}