@extends('layouts.app')

@section('content')

{{-- 1. HERO SECTION (Banner Utama) --}}
<section class="hero-section text-center text-lg-start py-5 mb-5">
    <div class="row align-items-center">
        {{-- Teks Hero --}}
        <div class="col-lg-6 order-2 order-lg-1">
            <h1 class="display-4 fw-bold text-dark mb-3">
                Temukan Kos Nyaman <br>
                <span class="text-primary">Sesuai Budgetmu</span>
            </h1>
            <p class="lead text-muted mb-4">
                Platform pencarian kos terbaik untuk mahasiswa dan karyawan. 
                Aman, transparan, dan tanpa biaya tersembunyi.
            </p>
            <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg fw-bold px-4 shadow-sm">
                    <i class="bi bi-search me-2"></i> Cari Kos Sekarang
                </a>
                <a href="#tentang" class="btn btn-outline-secondary btn-lg px-4">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            
            {{-- Statistik Singkat --}}
            <div class="row mt-5">
                <div class="col-4">
                    <h4 class="fw-bold text-dark mb-0">1.5k+</h4>
                    <small class="text-muted">Kamar Kos</small>
                </div>
                <div class="col-4 border-start border-end">
                    <h4 class="fw-bold text-dark mb-0">500+</h4>
                    <small class="text-muted">Pemilik Kos</small>
                </div>
                <div class="col-4">
                    <h4 class="fw-bold text-dark mb-0">4.8</h4>
                    <small class="text-muted">Rating User</small>
                </div>
            </div>
        </div>

        {{-- Gambar Ilustrasi (Kanan) --}}
        <div class="col-lg-6 order-1 order-lg-2 mb-5 mb-lg-0 text-center">
            {{-- Placeholder Gambar Hero --}}
            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mx-auto shadow-sm position-relative overflow-hidden" style="width: 100%; max-width: 500px; height: 400px;">
                <div class="text-center">
                    <i class="bi bi-houses-fill text-primary" style="font-size: 8rem; opacity: 0.2;"></i>
                    <p class="text-muted mt-3">Ilustrasi KosConnect</p>
                </div>
                
                {{-- Floating Badge --}}
                <div class="position-absolute bg-white px-3 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2" style="bottom: 30px; left: 30px;">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                        <i class="bi bi-check"></i>
                    </div>
                    <small class="fw-bold">Verifikasi Aman</small>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. KENAPA KAMI? (Features) --}}
<section id="tentang" class="py-5 mb-5">
    <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase letter-spacing-2">Kenapa KosConnect?</h6>
        <h2 class="fw-bold">Solusi Cari Kos Tanpa Ribet</h2>
    </div>

    <div class="row g-4">
        {{-- Fitur 1 --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4 card-hover">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                </div>
                <h5 class="fw-bold">Transaksi Aman</h5>
                <p class="text-muted small">Pembayaran dikelola oleh sistem (Midtrans) sehingga uangmu aman sampai kamu check-in.</p>
            </div>
        </div>

        {{-- Fitur 2 --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4 card-hover">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-geo-alt fs-3"></i>
                    </div>
                </div>
                <h5 class="fw-bold">Lokasi Strategis</h5>
                <p class="text-muted small">Temukan kos di dekat kampus atau kantor dengan fitur filter lokasi yang akurat.</p>
            </div>
        </div>

        {{-- Fitur 3 --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4 card-hover">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-chat-dots fs-3"></i>
                    </div>
                </div>
                <h5 class="fw-bold">Chat Langsung</h5>
                <p class="text-muted small">Tanya jawab dengan pemilik kos secara langsung sebelum kamu memutuskan untuk booking.</p>
            </div>
        </div>
    </div>
</section>

{{-- 3. CTA UNTUK OWNER --}}
<section class="bg-primary text-white rounded-4 p-5 text-center position-relative overflow-hidden mb-5">
    {{-- Dekorasi Background --}}
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-10" style="background-image: radial-gradient(circle, #ffffff 2px, transparent 2.5px); background-size: 30px 30px;"></div>
    
    <div class="position-relative z-1">
        <h2 class="fw-bold mb-3">Punya Kos Kosan Nganggur?</h2>
        <p class="lead mb-4 opacity-75">Bergabunglah dengan ratusan pemilik kos lainnya dan maksimalkan pendapatanmu.</p>
        
        @auth
            @if(Auth::user()->role === 'owner')
                <a href="{{ route('owner.dashboard') }}" class="btn btn-light text-primary fw-bold px-4 py-2 shadow-sm">
                    Ke Dashboard Owner
                </a>
            @else
                <button class="btn btn-light text-primary fw-bold px-4 py-2 shadow-sm disabled">
                    Kamu terdaftar sebagai Pencari Kos
                </button>
            @endif
        @else
            <a href="{{ route('register') }}" class="btn btn-light text-primary fw-bold px-4 py-2 shadow-sm">
                Daftar Sebagai Pemilik
            </a>
        @endauth
    </div>
</section>

<style>
    /* Styling Khusus Landing Page */
    .letter-spacing-2 { letter-spacing: 2px; }
    
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    /* Hero Animation (Opsional) */
    .hero-section img {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>

@endsection
