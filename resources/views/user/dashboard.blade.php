@extends('layouts.app')

@php
    $bodyClass = 'dash-user';
@endphp

@section('content')
<div class="user-dashboard">

    <div class="row">

        {{-- FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 90px; z-index: 100;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-funnel"></i> Filter
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('user.dashboard') }}">
                        {{-- isi filter --}}
                        <div class="d-grid gap-2 mt-2">
                            <button class="btn btn-primary btn-sm fw-bold">Terapkan Filter</button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- LIST KOS --}}
        <div class="col-lg-9">
            <h4 class="section-title">Rekomendasi Kos</h4>
            <div class="row g-4 justify-content-center">
                @forelse($properties as $p)
                    <div class="col-md-6 col-xl-4">
                        <div class="card property-card h-100 shadow-sm">
                            <img src="{{ optional($p->images->first())->file_path ? asset('storage/'.$p->images->first()->file_path) : 'https://placehold.co/600x400' }}"
                                 class="card-img-top">
                            <div class="card-body">
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $p->district ?? $p->city }}</small>
                                <h6 class="fw-bold mt-1">{{ $p->name }}</h6>
                                <div class="text-primary fw-bold">Rp {{ number_format($p->price,0,',','.') }}/bulan</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        Tidak ada kos ditemukan
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- =====================================================
     STYLE LANGSUNG DI DASHBOARD
===================================================== --}}
<style>
    /* BASE */
    .user-dashboard {
        min-height: calc(100vh - 80px);
        background-color: var(--kosan-bg-section);
        padding: 2rem 0;
    }

    /* ROW CENTER CARDS */
    .user-dashboard .row {
        margin: 0;
        gap: 2rem;
    }

    .user-dashboard .row.justify-content-center {
        justify-content: center;
    }

    /* FILTER CARD */
    .user-dashboard .card.border-0.shadow-sm.sticky-top {
        background: var(--kosan-card-bg) !important;
        border: 1px solid var(--kosan-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08) !important;
        position: sticky;
        top: 90px;
        z-index: 100;
    }

    .user-dashboard .card-header .card-title {
        color: var(--kosan-text-main);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-dashboard .card-header .card-title i {
        color: var(--kosan-secondary);
        font-size: 1.2rem;
    }

    /* PROPERTY CARDS */
    .user-dashboard .property-card {
        max-width: 350px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        background: var(--kosan-card-bg);
        border: 1px solid var(--kosan-border);
    }

    .user-dashboard .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        border-color: var(--kosan-secondary);
    }

    .user-dashboard .property-card .card-img-top {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-bottom: 1px solid var(--kosan-border);
    }

    .user-dashboard .property-card h6.fw-bold {
        color: var(--kosan-text-main);
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    .user-dashboard .property-card .text-primary.fw-bold {
        color: var(--kosan-secondary);
        font-weight: 700;
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(188,204,220,0.3);
    }

    .user-dashboard .property-card small.text-muted {
        color: var(--kosan-text-muted);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .user-dashboard .property-card small.text-muted i {
        color: var(--kosan-secondary);
    }

    /* SECTION TITLE */
    .user-dashboard h4.section-title {
        color: var(--kosan-text-main);
        text-align: center;
        margin-bottom: 2rem;
        font-size: 1.75rem;
        font-weight: 700;
        border-bottom: 2px solid var(--kosan-primary);
        display: inline-block;
        padding-bottom: 0.75rem;
    }

    /* BUTTONS */
    .user-dashboard .btn-primary {
        background: var(--kosan-btn-primary);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.625rem 1rem;
    }

    .user-dashboard .btn-primary:hover {
        background: var(--kosan-btn-primary-hover);
        color: white;
    }

    .user-dashboard .btn-outline-secondary {
        color: var(--kosan-text-main);
        border: 1px solid var(--kosan-border);
    }

    .user-dashboard .btn-outline-secondary:hover {
        background-color: var(--kosan-primary);
        color: var(--kosan-text-main);
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .user-dashboard .row {
            flex-direction: column;
        }
        .user-dashboard .col-lg-9 {
            width: 100%;
            padding-left: 0;
        }
        .user-dashboard .property-card {
            margin: 0 auto;
        }
        .user-dashboard h4.section-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection
