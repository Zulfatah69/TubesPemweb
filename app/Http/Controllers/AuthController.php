<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return redirect()->route('register.email');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'login'    => 'required',
                'password' => 'required',
            ],
            [
                'login.required'    => 'Email atau Username wajib diisi',
                'password.required' => 'Password wajib diisi',
            ]
        );

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (Auth::attempt([
            $loginType => $request->login,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            return redirect(match (Auth::user()->role) {
                'admin' => '/admin/dashboard',
                'owner' => '/owner/dashboard',
                default => '/user/dashboard',
            });
        }

        return back()
            ->withErrors([
                'login' => 'Email/Username atau password salah',
            ])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
