<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotBlocked
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (bool) Auth::user()->is_blocked) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Akun Anda telah diblokir oleh admin.');
        }

        return $next($request);
    }
}
