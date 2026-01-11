<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthOtpController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.register-email');
    }

    public function sendCode(Request $request)
    {
        try {
            $request->validate(
                ['email' => 'required|email|unique:users,email'],
                [
                    'email.required' => 'Email wajib diisi',
                    'email.email'    => 'Format email tidak valid',
                    'email.unique'   => 'Email sudah terdaftar',
                ]
            );
        } catch (ValidationException $e) {
            return back()->withErrors([
                'email' => $e->errors()['email'][0],
            ]);
        }

        $code = rand(100000, 999999);

        DB::table('email_verifications')->where('email', $request->email)->delete();

        DB::table('email_verifications')->insert([
            'email'      => $request->email,
            'code'       => $code,
            'expired_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =========================
        // KIRIM OTP VIA MAIL LOG
        // (akan masuk ke Railway Logs)
        // =========================
        Mail::raw(
            "Kode verifikasi kamu: {$code}\n\nBerlaku selama 10 menit.\nEmail: {$request->email}",
            function ($m) use ($request) {
                $m->to($request->email)
                  ->subject('Kode Verifikasi Pendaftaran');
            }
        );

        Log::channel('stderr')->info('OTP GENERATED', [
            'email' => $request->email,
            'code' => $code,
        ]);

        // simpan email ke session
        session(['email' => $request->email]);

        return redirect()->route('register.verify')->with([
            'success' => 'Kode OTP telah dikirim (cek logs Railway)',
        ]);
    }

    public function showVerifyForm()
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('register.email');
        }

        return view('auth.register-verify', compact('email'));
    }

    public function completeRegister(Request $request)
    {
        try {
            $request->validate(
                [
                    'email'    => 'required|email',
                    'code'     => 'required|digits:6',
                    'name'     => 'required|string|max:255',
                    'username' => 'required|unique:users,username',
                    'phone'    => 'required|unique:users,phone',
                    'role'     => 'required|in:user,owner',
                    'password' => 'required|confirmed|min:6',
                ],
                [
                    'code.required'      => 'Kode OTP wajib diisi',
                    'code.digits'        => 'Kode OTP harus 6 digit',
                    'username.unique'    => 'Username sudah digunakan',
                    'phone.unique'       => 'Nomor HP sudah digunakan',
                    'password.confirmed' => 'Konfirmasi password tidak cocok',
                    'password.min'       => 'Password minimal 6 karakter',
                ]
            );
        } catch (ValidationException $e) {
            return back()
                ->withErrors([array_key_first($e->errors()) => collect($e->errors())->first()[0]])
                ->withInput();
        }

        $otp = DB::table('email_verifications')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expired_at', '>=', now())
            ->first();

        if (!$otp) {
            return back()
                ->withErrors(['code' => 'Kode OTP salah atau sudah kadaluarsa'])
                ->withInput();
        }

        $user = User::create([
            'name'              => $request->name,
            'username'          => $request->username,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'role'              => $request->role,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        DB::table('email_verifications')->where('email', $request->email)->delete();
        session()->forget('email');

        Auth::login($user);

        return redirect(
            $user->role === 'owner'
                ? route('owner.dashboard')
                : route('user.dashboard')
        )->with('success', 'Registrasi berhasil, selamat datang!');
    }
}
