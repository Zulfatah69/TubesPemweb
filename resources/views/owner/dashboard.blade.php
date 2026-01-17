@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dash-owner.css') }}">
@endpush

@section('content')

<div class="container py-5">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">Halo, {{ Auth::user()->name }} 👋</h3>
            <p class="text-slate-500 mb-0">Laporan performa bisnis dan ringkasan aktivitas kosan Anda.</p>
        </div>
        <a href="{{ route('owner.properties.create') }}" class="btn btn-slate-800 fw-bold px-4 py-2 rounded-pill shadow-slate">
            <i class="bi bi-plus-lg me-2"></i>Tambah Properti
        </a>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-4 mb-5">

        {{-- Total Properti --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 me-4">
                        <div class="bg-slate-100 text-slate-700 rounded-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-building fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-400 small mb-1 text-uppercase fw-bold tracking-wider">Total Properti</p>
                        <h3 class="fw-bold mb-0 text-slate-800">{{ $total_properties }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Booking --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 me-4">
                        <div class="bg-slate-100 text-slate-700 rounded-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-journal-check fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-400 small mb-1 text-uppercase fw-bold tracking-wider">Total Booking</p>
                        <h3 class="fw-bold mb-0 text-slate-800">{{ $total_bookings }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Perlu Konfirmasi --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 me-4">
                        <div class="bg-rose-50 text-rose-600 rounded-4 d-flex align-items-center justify-content-center position-relative" style="width: 60px; height: 60px;">
                            <i class="bi bi-hourglass-split fs-3"></i>
                            @if($pending_bookings > 0)
                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-rose-500 border border-white rounded-circle"></span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-400 small mb-1 text-uppercase fw-bold tracking-wider">Perlu Konfirmasi</p>
                        <h3 class="fw-bold mb-0 {{ $pending_bookings > 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ $pending_bookings }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MENU PINTAS (QUICK ACTIONS) --}}
    <h5 class="fw-bold text-slate-700 mb-4">Navigasi Cepat</h5>
    <div class="row g-4">

        {{-- Tombol Chat --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.chats') }}" class="card text-decoration-none action-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3">
                            <i class="bi bi-chat-left-text-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-slate-800 mb-1">Pesan Masuk</h6>
                            <small class="text-slate-400">Interaksi dengan penyewa</small>
                        </div>
                    </div>
                    @if(isset($totalChats) && $totalChats > 0)
                        <span class="badge bg-rose-500 rounded-pill px-2">{{ $totalChats }}</span>
                    @else
                        <i class="bi bi-arrow-right text-slate-300"></i>
                    @endif
                </div>
            </a>
        </div>

        {{-- Tombol Booking Masuk --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.booking.index') }}" class="card text-decoration-none action-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-slate-800 mb-1">Persetujuan Sewa</h6>
                            <small class="text-slate-400">Konfirmasi booking baru</small>
                        </div>
                    </div>
                    @if($pending_bookings > 0)
                        <span class="badge bg-slate-800 rounded-pill px-2">{{ $pending_bookings }}</span>
                    @else
                        <i class="bi bi-arrow-right text-slate-300"></i>
                    @endif
                </div>
            </a>
        </div>

        {{-- Tombol Kelola Properti --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('owner.properties.index') }}" class="card text-decoration-none action-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3">
                            <i class="bi bi-grid-1x2-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-slate-800 mb-1">Kelola Properti</h6>
                            <small class="text-slate-400">Atur ketersediaan unit</small>
                        </div>
                    </div>
                    <i class="bi bi-arrow-right text-slate-300"></i>
                </div>
            </a>
        </div>
    </div>

</div>

<style>
    :root {
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --rose-50: #fff1f2;
        --rose-500: #f43f5e;
        --rose-600: #e11d48;
    }

    body { background-color: #fcfcfd; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .bg-rose-50 { background-color: var(--rose-50); }
    .text-rose-600 { color: var(--rose-600); }
    .bg-rose-500 { background-color: var(--rose-500); }
    
    .tracking-wider { letter-spacing: 0.05em; }

    .btn-slate-800 { background: var(--slate-800); color: white; border: none; transition: 0.2s; }
    .btn-slate-800:hover { background: var(--slate-700); transform: translateY(-2px); color: white; }
    .shadow-slate { box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2); }

    .action-card {
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent !important;
    }

    .action-card:hover {
        transform: translateY(-8px);
        background-color: white;
        border-color: var(--slate-100) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05) !important;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        background: var(--slate-50);
        color: var(--slate-800);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: 0.3s;
    }

    .action-card:hover .icon-box {
        background: var(--slate-800);
        color: white;
    }

    .badge {
        font-weight: 600;
        font-size: 0.75rem;
    }
</style>

@endsection
