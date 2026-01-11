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

            $user = Auth::user();

            // === CEK VERIFIKASI EMAIL KE FIREBASE ===
            try {
                $firebase = app(FirebaseService::class);
                $firebaseUser = $firebase->getUserByEmail($user->email);

                if (!$firebaseUser->emailVerified) {
                    Auth::logout();

                    return back()->withErrors([
                        'login' => 'Akun belum diverifikasi. Silakan cek email Anda.'
                    ]);
                }

                // Update status lokal
                $user->is_verified = true;
                $user->save();

            } catch (\Exception $e) {
                Auth::logout();

                return back()->withErrors([
                    'login' => 'Gagal memverifikasi akun. Silakan coba lagi.'
                ]);
            }

            $request->session()->regenerate();

            return redirect(match ($user->role) {
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

        // Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Kirim email verifikasi via Firebase
        try {
            $firebase = new FirebaseService();
            $firebase->sendEmailVerification($request->email, $request->password);
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Gagal mengirim email verifikasi: ' . $e->getMessage()
            ]);
        }

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan cek email untuk verifikasi.');
    }

}
