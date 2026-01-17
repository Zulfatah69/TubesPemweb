@extends('layouts.app')

@section('title', 'Pesan Masuk')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold text-slate-800 mb-1">Pesan Masuk</h3>
                    <p class="text-muted small mb-0">Kelola komunikasi dengan calon penyewa properti Anda.</p>
                </div>
                <a href="{{ route('owner.dashboard') }}" class="btn btn-white shadow-sm btn-sm rounded-pill px-3 border border-slate-200 text-slate-700">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>

            {{-- SEARCH & FILTER BAR --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-body p-2">
                    <div class="input-group input-group-merge border-0">
                        <span class="input-group-text bg-transparent border-0 text-slate-400 ps-3">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-0 shadow-none ps-2" placeholder="Cari nama penyewa atau properti...">
                        <button class="btn btn-slate-100 text-slate-600 rounded-3 px-3 ms-2">
                            <i class="bi bi-sliders"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- LIST CHAT --}}
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="list-group list-group-flush">
                    
                    @forelse($chats as $chat)
                        <a href="{{ route('owner.chat.show', $chat->id) }}" class="list-group-item list-group-item-action p-4 chat-item border-slate-50">
                            <div class="d-flex align-items-center">
                                
                                {{-- AVATAR (Inisial Nama) --}}
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle shadow-sm d-flex align-items-center justify-content-center rounded-circle fw-bold" 
                                         style="width: 56px; height: 56px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white;">
                                        {{ substr($chat->user->name, 0, 1) }}
                                    </div>
                                    {{-- Status Online Indicator (Opsional) --}}
                                    <div class="online-indicator"></div>
                                </div>

                                {{-- KONTEN CHAT --}}
                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-slate-800 mb-0 text-truncate">{{ $chat->user->name }}</h6>
                                        <small class="text-slate-400" style="font-size: 0.7rem;">
                                            {{ $chat->updated_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    <div class="mb-1">
                                        <span class="badge bg-slate-100 text-slate-600 fw-medium p-1 px-2 mb-1" style="font-size: 0.65rem;">
                                            <i class="bi bi-house-door me-1"></i>{{ $chat->property->name }}
                                        </span>
                                    </div>

                                    <div class="text-slate-500 small text-truncate pe-4">
                                        {{-- Tampilkan pesan terakhir jika ada --}}
                                        {{ $chat->last_message ?? 'Klik untuk melihat detail percakapan...' }}
                                    </div>
                                </div>

                                {{-- INDIKATOR UNREAD (Contoh Statis) --}}
                                @if(rand(0,1)) {{-- Ganti dengan logic $chat->unread_count --}}
                                    <div class="ms-2">
                                        <span class="badge rounded-circle bg-slate-800 p-1" style="width: 8px; height: 8px; display: block;"></span>
                                    </div>
                                @endif

                                <div class="ms-3 text-slate-300">
                                    <i class="bi bi-chevron-right small"></i>
                                </div>
                            </div>
                        </a>
                    @empty
                        {{-- EMPTY STATE --}}
                        <div class="text-center py-5 my-4">
                            <div class="bg-slate-50 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                <i class="bi bi-chat-left-dots text-slate-300" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="fw-bold text-slate-800">Kotak Masuk Kosong</h5>
                            <p class="text-slate-500 small px-5">Saat ini belum ada pesan dari calon penyewa. Pastikan iklan properti Anda tetap aktif!</p>
                            <a href="{{ route('owner.properties.index') }}" class="btn btn-slate-800 btn-sm rounded-pill px-4 mt-2">Cek Properti Saya</a>
                        </div>
                    @endforelse

                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted small opacity-50">&copy; {{ date('Y') }} KosConnect Messaging System</p>
            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-400: #94a3b8;
        --slate-200: #e2e8f0;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    .text-slate-800 { color: var(--slate-800); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: var(--slate-400); }
    .bg-slate-100 { background-color: var(--slate-100); }
    .bg-slate-800 { background-color: var(--slate-800); }
    .border-slate-50 { border-color: var(--slate-50) !important; }
    .border-slate-200 { border-color: var(--slate-200) !important; }

    .btn-white { background: white; border: 1px solid var(--slate-200); }
    .btn-white:hover { background: var(--slate-50); color: var(--slate-800); }
    .btn-slate-800 { background: var(--slate-800); color: white; }
    .btn-slate-800:hover { background: var(--slate-600); color: white; }

    .chat-item {
        transition: all 0.2s ease;
        position: relative;
    }
    
    .chat-item:hover {
        background-color: var(--slate-50);
        z-index: 1;
        transform: scale(1.01);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .avatar-circle {
        font-size: 1.3rem;
        letter-spacing: -1px;
    }

    .input-group-merge {
        background: white;
        border-radius: 12px;
    }

    .online-indicator {
        width: 12px;
        height: 12px;
        background: #22c55e;
        border: 2px solid white;
        border-radius: 50%;
        position: absolute;
        bottom: 25px;
        left: 55px;
    }

    /* Custom Scrollbar (Opsional) */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 10px; }
</style>

@endsection