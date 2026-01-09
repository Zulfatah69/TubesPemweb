@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@section('content')

<div class="container py-4">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Halo, {{ Auth::user()->name }} 👋</h4>
            <p class="text-muted small mb-0">Pantau performa bisnis kosanmu hari ini.</p>
        </div>
        <a href="{{ route('owner.properties.create') }}" class="btn btn-primary fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Properti
        </a>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-3 mb-4">
        
        {{-- Total Properti --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $total_properties }}</h4>
                        <span class="text-muted small">Total Properti</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Masuk (Total) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="bi bi-journal-check fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $total_bookings }}</h4>
                        <span class="text-muted small">Total Booking</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menunggu Konfirmasi (Prioritas) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 {{ $pending_bookings > 0 ? 'border-start border-warning border-4' : '' }}">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 {{ $pending_bookings > 0 ? 'text-warning' : '' }}">{{ $pending_bookings }}</h4>
                        <span class="text-muted small">Perlu Konfirmasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MENU PINTAS (QUICK ACTIONS) --}}
    <h5 class="fw-bold text-dark mb-3">Menu Pintas</h5>
    <div class="row g-3">
        
        {{-- Tombol Chat --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.chats') }}" class="card text-decoration-none card-hover border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill text-primary fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Pesan Masuk</h6>
                            <small class="text-muted">Cek chat dari penyewa</small>
                        </div>
                    </div>
                    @if(isset($totalChats) && $totalChats > 0)
                        <span class="badge bg-danger rounded-pill">{{ $totalChats }}</span>
                    @else
                        <i class="bi bi-chevron-right text-muted"></i>
                    @endif
                </div>
            </a>
        </div>

        {{-- Tombol Booking Masuk --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.booking.index') }}" class="card text-decoration-none card-hover border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check-fill text-success fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Booking Masuk</h6>
                            <small class="text-muted">Setujui/Tolak sewa</small>
                        </div>
                    </div>
                    @if($pending_bookings > 0)
                        <span class="badge bg-warning text-dark rounded-pill">{{ $pending_bookings }}</span>
                    @else
                        <i class="bi bi-chevron-right text-muted"></i>
                    @endif
                </div>
            </a>
        </div>

        {{-- Tombol Kelola Properti --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.properties.index') }}" class="card text-decoration-none card-hover border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-houses-fill text-info fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Kelola Properti</h6>
                            <small class="text-muted">Edit data kosan kamu</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </a>
        </div>

    </div>

</div>

{{-- CSS Tambahan untuk efek hover card --}}
<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

@endsection