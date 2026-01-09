@extends('layouts.app')

@section('content')

{{-- BREADCRUMB NAVIGASI --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Kos</li>
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
    
    {{-- KOLOM KIRI: KONTEN UTAMA (FOTO, DESKRIPSI, FASILITAS) --}}
    <div class="col-lg-8">
        
        {{-- HEADER INFO --}}
        <div class="mb-4">
            <h2 class="fw-bold text-dark mb-2">{{ $property->name }}</h2>
            <div class="text-muted d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-danger"></i> 
                <span>{{ $property->district }}, {{ $property->city }}, {{ $property->province }}</span>
            </div>
            <div class="small text-muted mt-1 ps-4">
                {{ $property->address }}
            </div>
        </div>

        {{-- CAROUSEL FOTO --}}
        <div class="card border-0 shadow-sm overflow-hidden mb-4">
            @if($property->images && $property->images->count())
                <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($property->images as $index => $img)
                            <button type="button" data-bs-target="#carouselPhotos" data-bs-slide-to="{{ $index }}" class="{{ $index==0?'active':'' }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($property->images as $index => $img)
                            <div class="carousel-item {{ $index==0?'active':'' }}">
                                <img src="{{ asset('storage/'.$img->file_path) }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Foto Kos">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPhotos" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselPhotos" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    </button>
                </div>
            @else
                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 400px;">
                    <div class="text-center">
                        <i class="bi bi-image display-1"></i>
                        <p>Belum ada foto tersedia</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- FASILITAS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Fasilitas Utama</h5>
                @if($property->facilities)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($property->facilities as $f)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-normal">
                                <i class="bi bi-check-circle me-1"></i> {{ $f }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted fst-italic">Tidak ada data fasilitas.</p>
                @endif

                @if($property->custom_facilities)
                    <h5 class="fw-bold mt-4 mb-3">Fasilitas Tambahan</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($property->custom_facilities as $f)
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill fw-normal">
                                <i class="bi bi-plus-circle me-1"></i> {{ $f }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Deskripsi Kos</h5>
                <div class="text-secondary" style="white-space: pre-line; line-height: 1.6;">
                    {{ $property->description ?? 'Pemilik belum menambahkan deskripsi detail untuk kos ini.' }}
                </div>
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN: FORM BOOKING (STICKY) --}}
    <div class="col-lg-4">
        <div class="sticky-top" style="top: 90px; z-index: 99;">
            
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                    
                    {{-- HARGA --}}
                    <div class="mb-4">
                        <span class="text-muted small d-block">Harga Sewa</span>
                        <div class="d-flex align-items-end gap-1">
                            <h3 class="fw-bold text-primary mb-0">Rp {{ number_format($property->price, 0, ',', '.') }}</h3>
                            <span class="text-muted mb-1">/ bulan</span>
                        </div>
                    </div>

                    <hr class="opacity-25 my-4">

                    {{-- FORM BOOKING --}}
                    <form method="POST" action="{{ route('user.booking.store', $property->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Mulai Sewa</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Catatan (Opsional)</label>
                            <textarea name="note" class="form-control" rows="2" placeholder="Contoh: Saya akan check-in jam 2 siang"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold mb-3 shadow-sm">
                            <i class="bi bi-calendar-check me-2"></i> Ajukan Sewa
                        </button>
                    </form>

                    {{-- TOMBOL CHAT --}}
                    <form method="POST" action="{{ route('chat.start', $property->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100 py-2 fw-bold">
                            <i class="bi bi-chat-dots me-2"></i> Chat Pemilik
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted" style="font-size: 0.8rem;">
                            <i class="bi bi-shield-check me-1"></i> Transaksi aman lewat KosConnect
                        </small>
                    </div>

                </div>
            </div>

            {{-- MINI PROFILE OWNER (OPSIONAL) --}}
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Pemilik Kos</small>
                        <span class="fw-bold text-dark">Admin / Owner</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection