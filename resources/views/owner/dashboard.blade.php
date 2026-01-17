@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dash-owner.css') }}">
@endpush

@section('content')
<div class="container py-4">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text">Halo, {{ Auth::user()->name }} 👋</h4>
            <p class="text-muted small mb-0">Pantau performa bisnis dan aktivitas kosanmu hari ini.</p>
        </div>
        <a href="{{ route('owner.properties.create') }}" class="btn btn-primary fw-bold shadow-sm px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Properti
        </a>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-3 mb-4">
        {{-- Total Properti --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                            <i class="bi bi-building fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Total Properti</p>
                        <h4 class="fw-bold mb-0" style="color: #5F666E;">{{ $total_properties }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Booking --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-success bg-opacity-10 text-success rounded p-3">
                            <i class="bi bi-journal-check fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Total Booking</p>
                        <h4 class="fw-bold mb-0" style="color: #5F666E">{{ $total_bookings }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Perlu Konfirmasi --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-warning bg-opacity-10 text-warning rounded p-3 position-relative">
                            <i class="bi bi-hourglass-split fs-4"></i>
                            @if($pending_bookings > 0)
                                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Perlu Konfirmasi</p>
                        <h4 class="fw-bold mb-0" style="color: {{ $pending_bookings > 0 ? '#415879' : '#5F666E' }}">
    {{ $pending_bookings }}
</h4>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MENU PINTAS --}}
    <h5 class="fw-bold text">Menu Pintas</h5>
    <div class="row g-3">
        {{-- Tombol Chat --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.chats') }}" class="card text-decoration-none card-hover border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill text-primary fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold text" style="color: #5F666E;">Pesan Masuk</h6>
                            <small class="text-muted">Cek chat dari penyewa</small>
                        </div>
                    </div>
                    @if(isset($totalChats) && $totalChats > 0)
                        <span class="badge bg-danger rounded-pill" style="color: #5F666E;">{{ $totalChats }}</span>
                    @else
                        <i class="bi bi-chevron-right text-muted opacity-50"></i>
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
                            <h6 class="fw-bold text" style="color: #5F666E;">Booking Masuk</h6>
                            <small class="text-muted">Setujui atau tolak sewa</small>
                        </div>
                    </div>
                    @if($pending_bookings > 0)
                        <span class="badge bg-warning text-dark rounded-pill" style="color: #5F666E;">{{ $pending_bookings }}</span>
                    @else
                        <i class="bi bi-chevron-right text-muted opacity-50"></i>
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
                            <h6 class="fw-bold text" style="color: #5F666E;">Kelola Properti</h6>
                            <small class="text-muted">Edit data kosan kamu</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted opacity-50"></i>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection
