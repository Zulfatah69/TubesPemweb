<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:users,username'],
            'phone'     => ['required', 'string', 'max:20', 'unique:users,phone'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'role'      => ['required', 'in:admin,owner,user'],
            'password'  => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create($validated);

        Auth::login($user);

        return redirect($this->redirectRolePath($user->role))
            ->with('success', 'Registrasi berhasil!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required'],
            'password' => ['required'],
        ]);

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $credentials = [
            $login_type => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            $role = Auth::user()->role;

            return redirect($this->redirectRolePath($role));
        }

        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectRolePath($role)
    {
        return match ($role) {
            'admin' => '/admin/dashboard',
            'owner' => '/owner/dashboard',
            default => '/user/dashboard',
        };
    }
}
