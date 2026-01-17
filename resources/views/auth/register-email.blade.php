@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-5 col-lg-4">

            {{-- HEADER / ICON --}}
            <div class="text-center mb-5">
                <div class="register-header-icon shadow-sm mb-4">
                    <i class="bi bi-shield-lock-fill fs-2"></i>
                </div>
                <h4 class="fw-bold text-slate-800 mb-1">Daftar Akun Baru</h4>
                <p class="text-muted small">Langkah 1: Verifikasi Identitas Anda</p>
            </div>

            {{-- CARD FORM --}}
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5">

                    {{-- ALERT ERROR --}}
                    @if($errors->any())
                        <div class="alert alert-danger-custom d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success-custom d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.send') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider text-slate-600">Alamat Email Aktif</label>
                            <div class="input-group custom-input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control border-start-0 ps-0" 
                                    placeholder="nama@email.com"
                                    value="{{ old('email') }}" 
                                    required
                                    autofocus
                                >
                            </div>
                            <div class="form-text small text-muted mt-3 d-flex align-items-start">
                                <i class="bi bi-info-circle me-2 mt-1"></i>
                                <span>Kami akan mengirimkan 6-digit kode OTP untuk memastikan keamanan email Anda.</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-slate-800 w-100 py-3 fw-bold shadow-sm transition-all mb-2">
                            Kirim Kode OTP <i class="bi bi-arrow-right ms-2"></i>
                        </button>

                    </form>
                </div>
            </div>

            {{-- FOOTER LINK --}}
            <div class="text-center mt-5">
                <p class="text-muted small">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-slate-800 hover-underline">Masuk Sekarang</a>
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    /* Slate Palette & Core Variables */
    :root {
        --slate-800: #1e293b;
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-50: #f8fafc;
    }

    body {
        background-color: var(--slate-50);
    }

    .text-slate-800 { color: var(--slate-800); }
    .text-slate-600 { color: var(--slate-600); }
    .btn-slate-800 { 
        background-color: var(--slate-800); 
        color: white;
        border: none;
        border-radius: 12px;
    }
    .btn-slate-800:hover { 
        background-color: var(--slate-700); 
        color: white;
        transform: translateY(-2px);
    }

    .register-header-icon {
        background-color: white;
        color: var(--slate-800);
        width: 70px;
        height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
    }

    /* Custom Inputs */
    .custom-input-group {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .custom-input-group:focus-within {
        border-color: var(--slate-800);
        box-shadow: 0 0 0 4px rgba(30, 41, 59, 0.1) !important;
    }
    .custom-input-group .form-control {
        padding: 12px;
        border: none;
        font-size: 0.95rem;
    }
    .custom-input-group .input-group-text {
        padding-left: 15px;
        border: none;
    }

    /* Alerts */
    .alert-danger-custom {
        background-color: #fff1f2;
        color: #9f1239;
        border: 1px solid #fecdd3;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.85rem;
    }
    .alert-success-custom {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.85rem;
    }

    .tracking-wider { letter-spacing: 0.05em; }
    .transition-all { transition: all 0.3s ease; }
    .hover-underline:hover { text-decoration: underline !important; }

    /* Remove focus shadow from default bootstrap */
    .form-control:focus {
        box-shadow: none;
    }
</style>
@endsection