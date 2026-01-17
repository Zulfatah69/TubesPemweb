@extends('layouts.app')

@section('title', 'Chat Room')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">

            <div class="card border-0 shadow-lg overflow-hidden" style="height: 85vh; border-radius: 24px;">
        
                {{-- HEADER CHAT --}}
                <div class="card-header bg-white border-bottom p-3 px-4 d-flex align-items-center justify-content-between sticky-top z-1">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('user.chats') }}" class="btn btn-slate-100 btn-sm rounded-circle me-3 text-slate-600">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-3 bg-slate-800 text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px; font-size: 0.9rem; background: linear-gradient(135deg, #1e293b 0%, #475569 100%);">
                                {{ substr($chat->owner->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-slate-800">{{ $chat->owner->name }}</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    <i class="bi bi-building me-1"></i> {{ $chat->property->name }}
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end d-none d-sm-block">
                        <span class="badge bg-slate-50 text-slate-700 border border-slate-200 px-3 py-2 rounded-pill shadow-sm small">
                            Rp {{ number_format($chat->property->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- BODY CHAT --}}
                <div class="card-body bg-slate-50 p-4" id="chat-box" style="overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem;">
                    
                    @forelse($chat->messages as $msg)
                        @php $isMe = $msg->sender_id == auth()->id(); @endphp

                        <div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            <div class="msg-bubble p-3 shadow-sm {{ $isMe ? 'bg-slate-800 text-white shadow-slate' : 'bg-white text-slate-800 border border-slate-100' }}" 
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
                                <i class="bi bi-chat-dots text-slate-200 fs-1"></i>
                            </div>
                            <h6 class="fw-bold text-slate-400">Mulai Obrolan</h6>
                            <p class="small text-slate-400">Tanyakan sesuatu kepada pemilik kos.</p>
                        </div>
                    @endforelse
                </div>

                {{-- FOOTER (INPUT PESAN) --}}
                <div class="card-footer bg-white border-top p-3 px-4">
                    <form id="chat-form" method="POST" action="{{ route('chat.send', $chat->id) }}">
                        @csrf
                        <div class="input-group align-items-center">
                            <input type="text" name="message" id="message-input" 
                                   class="form-control border-0 bg-slate-100 rounded-pill px-4 py-2" 
                                   placeholder="Tulis pesan Anda..." required autocomplete="off"
                                   style="box-shadow: none;">
                            <button type="submit" class="btn btn-slate-800 rounded-circle ms-3 d-flex align-items-center justify-content-center shadow-lg" 
                                    style="width: 48px; height: 48px; flex-shrink: 0; transition: all 0.2s;">
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
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-400 { color: var(--slate-400); }
    .border-slate-100 { border-color: var(--slate-100) !important; }
    .border-slate-200 { border-color: var(--slate-200) !important; }

    .btn-slate-100 { background-color: var(--slate-100); color: var(--slate-600); border: none; }
    .btn-slate-100:hover { background-color: #e2e8f0; }

    .shadow-slate { box-shadow: 0 4px 12px 0 rgba(30, 41, 59, 0.15); }

    .btn-slate-800 { background-color: var(--slate-800); border: none; }
    .btn-slate-800:hover { background-color: var(--slate-700); transform: scale(1.05); }

    #chat-box::-webkit-scrollbar { width: 5px; }
    #chat-box::-webkit-scrollbar-track { background: transparent; }
    #chat-box::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    .msg-bubble { transition: transform 0.1s ease; word-wrap: break-word; }
</style>

<script>
const chatBox = document.getElementById('chat-box');
const authId = {{ auth()->id() }};

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}

function escapeHtml(text) {
    return text.replace(/[&<>"']/g, function(m) {
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'})[m];
    });
}

function renderMessage(msg) {
    const isMe = msg.sender_id == authId;
    const bubbleClass = isMe ? 'bg-slate-800 text-white shadow-slate' : 'bg-white text-slate-800 border border-slate-100';
    const radiusClass = isMe ? 'border-radius: 20px 20px 4px 20px;' : 'border-radius: 20px 20px 20px 4px;';

    return `
        <div class="d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}">
            <div class="msg-bubble p-3 shadow-sm ${bubbleClass}" style="max-width:80%; ${radiusClass}">
                <div class="mb-1" style="font-size:0.95rem; line-height:1.5;">${escapeHtml(msg.message)}</div>
                <div class="text-end" style="font-size:0.65rem; opacity:0.7;">
                    ${new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}
                    ${isMe ? '<i class="bi bi-check2-all ms-1"></i>' : ''}
                </div>
            </div>
        </div>
    `;
}

function loadMessages() {
    fetch("{{ route('chat.messages', $chat->id) }}", { cache: "no-store" })
        .then(r => r.json())
        .then(data => {
            const isAtBottom = chatBox.scrollHeight - chatBox.scrollTop <= chatBox.clientHeight + 100;
            chatBox.innerHTML = '';
            data.forEach(msg => {
                chatBox.insertAdjacentHTML('beforeend', renderMessage(msg));
            });
            if (isAtBottom) scrollToBottom();
        });
}

document.getElementById('chat-form').addEventListener('submit', function(e){
    e.preventDefault();
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    if(!message) return;
    input.value = '';

    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    }).then(() => loadMessages());
});

scrollToBottom();
setInterval(loadMessages, 3000);
</script>

@endsection
