<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockUser
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_blocked) {
            abort(403, 'Akun Anda diblokir.');
        }

        return $next($request);
    }
}
