@extends('layouts.app')

@section('title', 'Chat Room')

@section('content')
<style>
    /* Definisi Warna Slate Kustom */
    .bg-slate-50 { background-color: #f8fafc !important; }
    
    /* Warna Teks Slate 700 (Abu-abu gelap elegan) */
    .text-slate-700 { color: #334155 !important; }
    
    /* Warna Border Slate 200 (Abu-abu muda halus) */
    .border-slate-200 { border: 1px solid #e2e8f0 !important; }

    /* Opsional: memperhalus tampilan badge */
    .badge.shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }
</style>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">

            <div class="card border-0 shadow-lg overflow-hidden" style="height: 85vh; border-radius: 24px;">
                
                {{-- HEADER CHAT --}}
                <div class="card-header bg-white border-bottom p-3 px-4 d-flex align-items-center justify-content-between sticky-top z-1">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('owner.chats') }}" class="btn btn-slate-100 btn-sm rounded-circle me-3 text-slate-600">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-3 bg-slate-800 text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-size: 0.9rem;">
                                {{ substr($chat->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-slate-800">{{ $chat->user->name }}</h6>
                                <small class="text-success" style="font-size: 0.7rem;">
                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Online
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <span class="badge bg-slate-50 text-slate-700 border border-slate-200 px-3 py-2 rounded-pill shadow-sm small">
                            <span class="opacity-75 fw-normal">Unit:</span> {{ $chat->property->name }}
                        </span>
                    </div>
                </div>

                {{-- BODY CHAT --}}
                <div class="card-body bg-slate-50 p-4" id="chat-box" style="overflow-y: auto; display: flex; flex-direction: column; gap: 1rem;">
                    
                    {{-- System Date Separator --}}
                    <div class="text-center my-3">
                        <span class="badge bg-white text-slate-400 border border-slate-100 px-3 py-1 rounded-pill small fw-normal">Hari Ini</span>
                    </div>

                    @forelse($chat->messages as $msg)
                        @php $isMe = $msg->sender_id == auth()->id(); @endphp

                        <div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }} animate__animated animate__fadeInUp animate__faster">
                            <div class="msg-bubble p-3 {{ $isMe ? 'bg-slate-800 text-white shadow-slate' : 'bg-white text-slate-800 shadow-sm border border-slate-100' }}" 
                                 style="max-width: 80%; border-radius: {{ $isMe ? '20px 20px 4px 20px' : '20px 20px 20px 4px' }};">
                                
                                <div class="message-text mb-1" style="font-size: 0.95rem; line-height: 1.5;">
                                    {{ $msg->message }}
                                </div>
                                
                                <div class="text-end" style="font-size: 0.65rem; opacity: 0.7;">
                                    {{ $msg->created_at->format('H:i') }}
                                    @if($isMe) <i class="bi bi-check2-all ms-1"></i> @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center my-auto">
                            <div class="bg-white p-4 rounded-circle d-inline-block shadow-sm mb-3">
                                <i class="bi bi-chat-left-text text-slate-200 fs-1"></i>
                            </div>
                            <h6 class="fw-bold text-slate-400">Belum ada percakapan</h6>
                            <p class="small text-slate-400">Kirim pesan pertama untuk memulai.</p>
                        </div>
                    @endforelse
                </div>

                {{-- FOOTER (INPUT PESAN) --}}
                <div class="card-footer bg-white border-top p-3 px-4">
                    <form id="chat-form" method="POST" action="{{ route('owner.chat.send', $chat->id) }}">
                        @csrf
                        <div class="input-group align-items-center">
                            <button type="button" class="btn btn-link text-slate-400 px-2 me-2">
                                <i class="bi bi-plus-circle fs-5"></i>
                            </button>
                            <input type="text" name="message" id="message-input" 
                                   class="form-control border-0 bg-slate-100 rounded-pill px-4 py-2" 
                                   placeholder="Ketik pesan Anda..." required autocomplete="off"
                                   style="box-shadow: none;">
                            <button type="submit" class="btn btn-slate-800 rounded-circle ms-3 d-flex align-items-center justify-content-center shadow-lg" 
                                    style="width: 48px; height: 48px; flex-shrink: 0;">
                                <i class="bi bi-send-fill text-white"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --slate-800: #1e293b;
        --slate-700: #334155;
        --slate-400: #94a3b8;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    .bg-slate-50 { background-color: var(--slate-50); }
    .bg-slate-100 { background-color: var(--slate-100); }
    .bg-slate-800 { background-color: var(--slate-800); }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-400 { color: var(--slate-400); }
    .border-slate-100 { border-color: var(--slate-100) !important; }
    .border-slate-200 { border-color: var(--slate-200) !important; }

    .shadow-slate {
        box-shadow: 0 4px 14px 0 rgba(30, 41, 59, 0.25);
    }

    .btn-slate-800 {
        background-color: var(--slate-800);
        transition: all 0.2s;
    }

    .btn-slate-800:hover {
        background-color: var(--slate-700);
        transform: scale(1.05);
    }

    #chat-box::-webkit-scrollbar {
        width: 5px;
    }
    #chat-box::-webkit-scrollbar-track {
        background: transparent; 
    }
    #chat-box::-webkit-scrollbar-thumb {
        background: #e2e8f0; 
        border-radius: 10px;
    }

    .msg-bubble {
        transition: transform 0.2s ease;
    }
    
    .msg-bubble:hover {
        transform: translateY(-2px);
    }
</style>

<script>
    // Logic Javascript Anda (loadMessages, scrollToBottom, dsb) tetap sama, 
    // namun pastikan renderMessage menggunakan class styling yang baru:
    
    function renderMessage(msg) {
        const isMe = msg.sender_id == authId;
        const bubbleStyle = isMe 
            ? 'bg-slate-800 text-white shadow-slate' 
            : 'bg-white text-slate-800 shadow-sm border border-slate-100';
        const borderRadius = isMe 
            ? 'border-radius: 20px 20px 4px 20px;' 
            : 'border-radius: 20px 20px 20px 4px;';

        return `
            <div class="d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}">
                <div class="msg-bubble p-3 ${bubbleStyle}" style="max-width:80%; ${borderRadius}">
                    <div class="mb-1" style="font-size:0.95rem;">${escapeHtml(msg.message)}</div>
                    <div class="text-end" style="font-size:0.65rem;opacity:.7;">
                        ${new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}
                        ${isMe ? '<i class="bi bi-check2-all ms-1"></i>' : ''}
                    </div>
                </div>
            </div>
        `;
    }
</script>

@endsection