@extends('layouts.app')

@section('title', 'Chat Saya')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Pesan Masuk</h4>
                    <p class="text-muted small mb-0">Riwayat percakapan dengan pemilik kos.</p>
                </div>
                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-house me-1"></i> Home
                </a>
            </div>

            {{-- SEARCH BAR (Kosmetik) --}}
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari percakapan...">
                </div>
            </div>

            {{-- LIST CHAT --}}
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="list-group list-group-flush">
                    
                    @forelse($owners as $owner)
    <a href="{{ route('user.chats.show', $owner->id) }}" class="list-group-item list-group-item-action p-3 chat-item border-bottom">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <div class="avatar-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 50px; height: 50px;">
                    {{ substr($owner->name, 0, 1) }}
                </div>
            </div>
            <div class="flex-grow-1 ms-3 overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="fw-bold text-dark mb-0 text-truncate">{{ $owner->name }}</h6>
                    <small class="text-muted" style="font-size: 0.75rem;">-</small>
                </div>
            </div>
            <div class="ms-2 text-muted opacity-50">
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>
    </a>
@empty
    <div class="text-center py-5">
        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-chat-square-text fs-1 text-muted opacity-50"></i>
        </div>
        <h6 class="fw-bold text-dark">Belum ada owner</h6>
        <p class="text-muted small mb-4">Saat ini belum ada pemilik kos yang bisa dihubungi.</p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary fw-bold px-4">
            <i class="bi bi-search me-2"></i> Cari Kos Dulu
        </a>
    </div>
@endforelse


                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .chat-item {
        transition: background-color 0.2s ease, padding-left 0.2s ease;
    }
    .chat-item:hover {
        background-color: #f8f9fa;
        padding-left: 1.2rem !important;
    }
    .avatar-circle {
        font-size: 1.2rem;
    }
</style>

@endsection