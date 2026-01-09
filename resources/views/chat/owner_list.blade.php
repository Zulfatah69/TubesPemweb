@extends('layouts.app')

@section('title', 'Pesan Masuk')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Pesan Masuk</h4>
                    <p class="text-muted small mb-0">Daftar percakapan dengan calon penyewa.</p>
                </div>
                {{-- Tombol Kembali --}}
                <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>

            {{-- SEARCH BAR (Opsional / Kosmetik) --}}
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari nama penyewa...">
                </div>
            </div>

            {{-- LIST CHAT --}}
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="list-group list-group-flush">
                    
                    @forelse($chats as $chat)
                        <a href="{{ route('owner.chat.show', $chat->id) }}" class="list-group-item list-group-item-action p-3 chat-item border-bottom">
                            <div class="d-flex align-items-center">
                                
                                {{-- AVATAR (Inisial Nama) --}}
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 50px; height: 50px;">
                                        {{ substr($chat->user->name, 0, 1) }}
                                    </div>
                                </div>

                                {{-- KONTEN CHAT --}}
                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate">{{ $chat->user->name }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            {{ $chat->updated_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="bi bi-building me-1 text-secondary"></i> 
                                        <span class="text-truncate">Menanyakan: {{ $chat->property->name }}</span>
                                    </div>
                                </div>

                                {{-- INDIKATOR (Chevron) --}}
                                <div class="ms-2 text-muted opacity-50">
                                    <i class="bi bi-chevron-right"></i>
                                </div>

                            </div>
                        </a>
                    @empty
                        {{-- EMPTY STATE --}}
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-chat-dots-fill fs-2 text-muted opacity-50"></i>
                            </div>
                            <h6 class="fw-bold text-muted">Belum ada pesan</h6>
                            <p class="small text-muted mb-0">Pesan dari penyewa akan muncul di sini.</p>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .chat-item {
        transition: background-color 0.2s;
    }
    .chat-item:hover {
        background-color: #f8f9fa;
    }
    .avatar-circle {
        font-size: 1.2rem;
    }
</style>

@endsection