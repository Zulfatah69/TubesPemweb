@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">

            {{-- HEADER / ICON --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 70px; height: 70px;">
                    <i class="bi bi-envelope-plus-fill fs-2"></i>
                </div>
                <h4 class="fw-bold text-dark">Daftar Akun Baru</h4>
                <p class="text-muted small">Langkah 1: Verifikasi Email Anda</p>
            </div>

            {{-- CARD FORM --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    {{-- ALERT ERROR --}}
                    @if($errors->any())
                        <div class="alert alert-danger d-flex align-items-center small mb-3" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center small mb-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.send') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control border-start-0 ps-0" 
                                    placeholder="contoh@email.com"
                                    value="{{ old('email') }}" 
                                    required
                                    autofocus
                                >
                            </div>
                            <div class="form-text small text-muted mt-2">
                                Kami akan mengirimkan kode OTP ke email ini.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            Kirim Kode Verifikasi <i class="bi bi-arrow-right ms-1"></i>
                        </button>

                    </form>
                </div>
            </div>

            {{-- FOOTER LINK --}}
            <div class="text-center mt-4">
                <p class="text-muted small">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Masuk disini</a>
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    /* Sedikit styling tambahan khusus halaman ini agar input group rapi */
    .input-group-text {
        border-color: #dee2e6;
    }
    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none; /* Kita handle focus di input-group parent jika perlu, atau biarkan default */
        border-left: none;
    }
    /* Trik agar border input group terlihat menyatu saat fokus */
    .input-group:focus-within .form-control, 
    .input-group:focus-within .input-group-text {
        border-color: var(--bs-primary);
        box-shadow: none; 
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-radius: 0.375rem;
    }
</style>
@endsection