@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb x-small tracking-widest text-uppercase">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none text-slate-400">Home</a></li>
            <li class="breadcrumb-item active text-slate-800 fw-bold" aria-current="page">Detail Properti</li>
        </ol>
    </nav>

    {{-- ALERT SYSTEM --}}
   @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="row g-4">
        
        {{-- KOLOM KIRI: KONTEN UTAMA --}}
        <div class="col-lg-8">
            
            {{-- HEADER INFO --}}
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    @php
                        $badgeStyles = match($property->gender_type){
                            'putra' => 'bg-slate-800 text-white',
                            'putri' => 'bg-rose-500 text-white',
                            'campuran' => 'bg-emerald-500 text-white',
                            default => 'bg-slate-200'
                        };
                    @endphp
                    <span class="badge {{ $badgeStyles }} rounded-pill px-3 py-2 x-small fw-bold">{{ strtoupper($property->gender_type) }}</span>
                    <span class="text-slate-400 x-small fw-bold"><i class="bi bi-star-fill text-warning me-1"></i> Terverifikasi</span>
                </div>
                <h1 class="fw-bold text-slate-800 display-6 mb-2">{{ $property->name }}</h1>
                <div class="text-slate-500 d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-rose-500"></i> 
                    <span class="fw-medium">{{ $property->district }}, {{ $property->city }}</span>
                </div>
            </div>

            {{-- GALLERY FOTO --}}
            <div class="card border-0 shadow-sm overflow-hidden mb-5" style="border-radius: 24px;">
                @if($property->images && $property->images->count())
                    <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($property->images as $index => $img)
                                <div class="carousel-item {{ $index==0?'active':'' }}">
                                    <img src="{{ asset($img->file_path) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Property Image">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPhotos" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-slate-800 rounded-circle p-3" aria-hidden="true" style="background-size: 50%;"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselPhotos" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-slate-800 rounded-circle p-3" aria-hidden="true" style="background-size: 50%;"></span>
                        </button>

                    </div>
                @else
                    <div class="bg-slate-50 d-flex align-items-center justify-content-center text-slate-300" style="height: 400px;">
                        <div class="text-center">
                            <i class="bi bi-image display-1"></i>
                            <p class="fw-bold mt-2">Gambar belum diunggah</p>
                        </div>
                    </div>
                @endif
            </div>
            {{-- FASILITAS --}}
            <div class="mb-5">
                <h4 class="fw-bold text-slate-800 mb-4">Fasilitas Properti</h4>
                <div class="row g-3">
                    @if($property->facilities)
                        @foreach($property->facilities as $f)
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center p-3 rounded-4 border border-slate-100 bg-white">
                                    <i class="bi bi-check-circle-fill text-emerald-500 me-3"></i>
                                    <span class="text-slate-700 fw-medium">{{ $f }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- DESKRIPSI --}}
            <div class="mb-5">
                <h4 class="fw-bold text-slate-800 mb-3">Tentang Kos Ini</h4>
                <div class="text-slate-600 fs-6" style="white-space: pre-line; line-height: 1.8;">
                    {{ $property->description ?? 'Pemilik belum memberikan deskripsi lengkap.' }}
                </div>
            </div>

            <hr class="border-slate-100 my-5">

        </div>

        {{-- KOLOM KANAN: FORM BOOKING (STICKY) --}}
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                
                <div class="card border-0 shadow-slate-lg overflow-hidden" style="border-radius: 28px;">
                    <div class="card-body p-4 p-md-5">
                        
                        {{-- HARGA --}}
                        <div class="mb-4">
                            <small class="text-slate-400 fw-bold text-uppercase tracking-wider d-block mb-1">Harga Sewa</small>
                            <div class="d-flex align-items-baseline gap-2">
                                <h2 class="fw-bold text-slate-800 mb-0">Rp {{ number_format($property->price, 0, ',', '.') }}</h2>
                                <span class="text-slate-400 fw-medium">/ bulan</span>
                            </div>
                        </div>
                        <hr class="border-slate-50 my-4">

                        {{-- FORM BOOKING --}}
                        <form method="POST" action="{{ route('user.booking.store', $property->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-slate-700 fw-bold small">Tanggal Mulai Sewa</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-slate-50 border-slate-100 text-slate-400"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="start_date" class="form-control border-slate-100 bg-slate-50 shadow-none" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-slate-700 fw-bold small">Durasi (Bulan)</label>
                                <input type="number" name="months" class="form-control border-slate-100 bg-slate-50 shadow-none" value="1" min="1" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-slate-700 fw-bold small">Catatan Tambahan</label>
                                <textarea name="note" class="form-control border-slate-100 bg-slate-50 shadow-none" rows="2" placeholder="Tanyakan sesuatu ke pemilik..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-slate-800 w-100 py-3 rounded-pill fw-bold mb-3 shadow-slate transition-all hover-up">
                                <i class="bi bi-lightning-charge-fill me-2"></i> Ajukan Booking
                            </button>
                        </form>

                        {{-- CHAT --}}
                        <form method="POST" action="{{ route('chat.start', $property->owner_id) }}">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                            <button type="submit" class="btn btn-white border border-slate-200 text-slate-600 w-100 py-3 rounded-pill fw-bold hover-bg-slate">
                                <i class="bi bi-chat-left-dots me-2"></i> Tanya Pemilik
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <div class="d-inline-flex align-items-center gap-2 py-1 px-3 bg-slate-50 rounded-pill">
                                <i class="bi bi-shield-lock-fill text-emerald-500 x-small"></i>
                                <span class="text-slate-500" style="font-size: 0.7rem;">Data Transaksi Terenkripsi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --rose-500: #f43f5e;
        --emerald-500: #10b981;
    }

    body { background-color: #fcfcfd; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .text-emerald-500 { color: var(--emerald-500); }
    .bg-slate-50 { background-color: var(--slate-50); }
    .bg-slate-800 { background-color: var(--slate-800); }
    .border-slate-100 { border-color: var(--slate-100) !important; }

    .x-small { font-size: 0.7rem; }
    .tracking-widest { letter-spacing: 0.15em; }

    .shadow-slate-lg { box-shadow: 0 25px 50px -12px rgba(30, 41, 59, 0.12); }
    .shadow-slate { box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2); }

    .btn-slate-800 { background: var(--slate-800); color: white; border: none; }
    .btn-slate-800:hover { background: #0f172a; color: white; transform: translateY(-2px); }
    
    .hover-bg-slate:hover { background-color: var(--slate-50); border-color: var(--slate-300); }
    
    .carousel-item img {
        transition: transform 0.5s ease;
    }
    
    .hover-up { transition: all 0.3s ease; }
    .hover-up:hover { transform: translateY(-3px); }

    .form-control:focus {
        border-color: var(--slate-300);
        box-shadow: none;
        background-color: #fff;
    }
</style>
@endsection