<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (bool) Auth::user()->is_blocked) {

            Auth::logout();

            // Hancurkan session lama
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Akun Anda telah diblokir oleh admin.');
        }

        return $next($request);
    }
}
