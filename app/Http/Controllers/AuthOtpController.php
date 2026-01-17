<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash; // <-- tambahkan ini
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
            $request->validate(['email' => 'required|email|unique:users,email']);
        } catch (ValidationException $e) {
            return back()->withErrors(['email' => $e->errors()['email'][0]]);
        }

        $code = rand(100000, 999999);

        DB::table('email_verifications')->where('email', $request->email)->delete();

        DB::table('email_verifications')->insert([
            'email' => $request->email,
            'code' => $code,
            'expired_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::raw("Kode OTP: {$code}", function ($m) use ($request) {
            $m->to($request->email)->subject('OTP Register');
        });

        Log::channel('stderr')->info('OTP', ['email' => $request->email, 'code' => $code]);

        session(['email' => $request->email]);

        return redirect()->route('register.verify');
    }

    public function showVerifyForm()
    {
        $email = session('email');
        if (!$email) return redirect()->route('register.email');
        return view('auth.register-verify', compact('email'));
    }

    public function completeRegister(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'code' => 'required|digits:6',
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'phone' => 'required|unique:users,phone',
                'role' => 'required|in:user,owner',
                'password' => 'required|confirmed|min:6',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors([array_key_first($e->errors()) => collect($e->errors())->first()[0]])->withInput();
        }

        $otp = DB::table('email_verifications')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expired_at', '>=', now())
            ->first();

        if (!$otp) return back()->withErrors(['code' => 'OTP salah'])->withInput();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password), // <-- hash password
                'email_verified_at' => now(),
            ]);

            DB::table('email_verifications')->where('email', $request->email)->delete();
            session()->forget('email');

            Auth::login($user);

            DB::commit();

            return redirect($user->role === 'owner' ? route('owner.dashboard') : route('user.dashboard'));

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('stderr')->error('REGISTER_FAILED', ['error' => $e->getMessage()]);
            return back()->withErrors(['register' => 'Registrasi gagal']);
        }
    }
}
