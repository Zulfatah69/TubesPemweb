<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;
use App\Models\User;

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

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (Auth::attempt([
            $loginType => $request->login,
            'password' => $request->password,
        ])) {

            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun belum diverifikasi.'
                ]);
            }

            $request->session()->regenerate();

            return redirect(match ($user->role) {
                'admin' => '/admin/dashboard',
                'owner' => '/owner/dashboard',
                default => '/user/dashboard',
            });
        }

        return back()->withErrors([
            'login' => 'Email/Username atau password salah'
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,owner'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => $request->password,
        ]);

        try {
            $firebase = new FirebaseService();
            $firebase->sendEmailVerification($request->email, $request->password);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email verifikasi']);
        }

        return redirect('/login')->with('success', 'Akun berhasil dibuat.');
    }
}
