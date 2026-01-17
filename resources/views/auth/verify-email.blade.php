@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-5">
            
            <div class="card border-0 shadow-lg p-2" style="border-radius: 24px;">
                <div class="card-body text-center p-4 p-md-5">

                    {{-- ICON ILLUSTRATION --}}
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="bg-slate-100 text-slate-800 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 90px; height: 90px;">
                            <i class="bi bi-envelope-paper-heart fs-1"></i>
                        </div>
                    </div>

                    <h4 class="fw-bold text-slate-800 mb-3">Verifikasi Email Anda</h4>
                    
                    <p class="text-muted mb-4 px-lg-3">
                        Terima kasih telah bergabung! Silakan periksa kotak masuk email Anda dan klik **link verifikasi** yang baru saja kami kirimkan untuk mengaktifkan akun.
                    </p>

                    {{-- ALERT SUKSES KIRIM ULANG --}}
                    @if (session('status') == 'verification-link-sent' || session('success'))
                        <div class="alert alert-success-custom d-flex align-items-center text-start mb-4 animate__animated animate__fadeIn" role="alert">
                            <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                            <div class="small">
                                Link verifikasi baru telah berhasil dikirim ke alamat email yang Anda daftarkan.
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        {{-- TOMBOL KIRIM ULANG --}}
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-slate-800 w-100 fw-bold py-3 shadow-sm transition-all mb-2">
                                <i class="bi bi-arrow-clockwise me-2"></i> Kirim Ulang Email
                            </button>
                        </form>

                        {{-- TOMBOL LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-slate-600 hover-slate-800 w-100 btn-sm mt-2 transition-all">
                                <i class="bi bi-box-arrow-left me-1"></i> Salah memasukkan email? <span class="fw-bold">Keluar</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="text-muted small opacity-75">
                    &copy; {{ date('Y') }} <strong>KosConnect</strong>. <br>
                    Butuh bantuan? <a href="#" class="text-slate-700 fw-bold text-decoration-none">Hubungi Support</a>
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --slate-800: #1e293b;
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    body {
        background-color: var(--slate-50);
        background-image: radial-gradient(circle at 50% 50%, rgba(30, 41, 59, 0.02) 0%, transparent 50%);
    }

    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-600 { color: var(--slate-600); }
    .bg-slate-100 { background-color: var(--slate-100); }

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

    .hover-slate-800:hover {
        color: var(--slate-800) !important;
    }

    .alert-success-custom {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        border-radius: 16px;
        padding: 16px;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    /* Subtle animation for the alert */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate__fadeIn {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endsection