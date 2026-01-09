@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            
            <div class="card border-0 shadow-sm p-3">
                <div class="card-body text-center">

                    {{-- ICON ILLUSTRATION --}}
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-envelope-check-fill fs-1"></i>
                        </div>
                    </div>

                    <h4 class="fw-bold text-dark mb-3">Verifikasi Email Kamu</h4>
                    
                    <p class="text-muted mb-4">
                        Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email kamu dengan mengklik link yang baru saja kami kirimkan ke email kamu.
                    </p>

                    {{-- ALERT SUKSES KIRIM ULANG --}}
                    @if (session('status') == 'verification-link-sent' || session('success'))
                        <div class="alert alert-success d-flex align-items-center text-start small mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div>
                                Link verifikasi baru telah dikirim ke alamat email yang kamu daftarkan.
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        {{-- TOMBOL KIRIM ULANG --}}
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                <i class="bi bi-send me-2"></i> Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        {{-- TOMBOL LOGOUT (PENTING: Jika user salah input email, mereka bisa logout) --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-muted w-100 btn-sm mt-2">
                                <i class="bi bi-box-arrow-left me-1"></i> Salah email? Log Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            
            <div class="text-center mt-4 text-muted small">
                &copy; {{ date('Y') }} KosConnect.
            </div>

        </div>
    </div>
</div>
@endsection