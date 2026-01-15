@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register-email.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">

            {{-- HEADER / ICON --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-3"
                     style="width: 70px; height: 70px;">
                    <i class="bi bi-envelope-plus-fill fs-2"></i>
                </div>
                <h4 class="fw-bold">Daftar Akun Baru</h4>
                <p class="text-muted small">Langkah 1: Verifikasi Email Anda</p>
            </div>

            {{-- CARD FORM --}}
            <div class="card">
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger d-flex align-items-center small mb-3">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center small mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.send') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="contoh@email.com"
                                       value="{{ old('email') }}"
                                       required autofocus>
                            </div>
                            <div class="form-text small text-muted mt-2">
                                Kami akan mengirimkan kode OTP ke email ini.
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 py-2 fw-bold">
                            Kirim Kode Verifikasi
                            <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="text-center mt-4">
                <p class="text-muted small">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none">
                        Masuk disini
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
