<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Blocked
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_blocked) { // misal kolom is_blocked di DB
            abort(403, 'Akun Anda diblokir');
        }
        return $next($request);
    }
}
