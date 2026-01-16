@extends('layouts.app')

@section('title', 'Chat Room')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card border-0 shadow-sm overflow-hidden" style="height: 80vh;">

                {{-- HEADER CHAT --}}
                <div class="card-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between sticky-top z-1">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('user.chats') }}" class="btn btn-light btn-sm rounded-circle me-3 text-muted">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            {{-- Nama Pemilik --}}
                            <h6 class="fw-bold mb-0 text-dark">{{ $owner->name }}</h6>
                            {{-- Info Properti --}}
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-building-fill me-1 text-secondary"></i> 
                                {{ $chats->first()?->property->name ?? '-' }}
                            </small>
                        </div>
                    </div>
                    
                    {{-- Harga Kos (Info Cepat) --}}
                    <div class="text-end d-none d-sm-block">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            Rp {{ number_format($chats->first()?->property->price ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- BODY CHAT --}}
                <div class="card-body bg-light p-4" id="chat-box" style="overflow-y: auto; display: flex; flex-direction: column;">
                    
                    @forelse($chats as $chat)
                        @foreach($chat->messages as $msg)
                            @php
                                $isMe = $msg->sender_id == auth()->id();
                            @endphp

                            <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="msg-bubble p-3 shadow-sm {{ $isMe ? 'bg-primary text-white rounded-end-top-0' : 'bg-white text-dark rounded-start-top-0' }}" 
                                     style="max-width: 75%; border-radius: 15px; position: relative;">
                                    
                                    <div class="mb-1">{{ $msg->message }}</div>
                                    
                                    <div class="text-end" style="font-size: 0.65rem; opacity: 0.7;">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($isMe) <i class="bi bi-check2-all ms-1"></i> @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @empty
                        <div class="text-center mt-5">
                            <div class="bg-white p-3 rounded-circle d-inline-block shadow-sm mb-3">
                                <i class="bi bi-chat-text text-primary fs-1"></i>
                            </div>
                            <p class="text-muted">Halo! Tanyakan ketersediaan kamar atau info lainnya kepada pemilik.</p>
                        </div>
                    @endforelse

                </div>

                {{-- FOOTER (INPUT) --}}
                <div class="card-footer bg-white border-top p-3">
    <form id="chat-form" method="POST" action="{{ route('chat.send', $owner->id) }}">
        @csrf
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required>
            <button class="btn btn-primary" type="submit">Kirim</button>
        </div>
    </form>
</div>

            </div>

        </div>
    </div>
</div>

<script>
const chatBox = document.getElementById('chat-box');
const authId = {{ auth()->id() }};

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}

function escapeHtml(text) {
    return text.replace(/[&<>"']/g, function(m) {
        return ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':'&quot;',"'":'&#039;'}[m]);
    });
}

function renderMessage(msg) {
    const isMe = msg.sender_id == authId;

    return `
        <div class="d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}">
            <div class="p-3 shadow-sm ${isMe ? 'bg-primary text-white' : 'bg-white text-dark'}"
                 style="max-width:75%; border-radius:15px;">
                <div class="mb-1">${escapeHtml(msg.message)}</div>
                <div class="text-end" style="font-size:0.65rem;opacity:.7;">
                    ${new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}
                </div>
            </div>
        </div>
    `;
}

function loadMessages() {
    fetch("{{ route('chat.messages', $owner->id) }}", { cache: "no-store" })
        .then(r => r.json())
        .then(data => {
            chatBox.innerHTML = '';
            data.forEach(msg => chatBox.insertAdjacentHTML('beforeend', renderMessage(msg)));
            scrollToBottom();
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

// load awal
loadMessages();
setInterval(loadMessages, 2000);
</script>

<style>
#chat-box::-webkit-scrollbar { width: 6px; }
#chat-box::-webkit-scrollbar-track { background: #f1f1f1; }
#chat-box::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
#chat-box::-webkit-scrollbar-thumb:hover { background: #aaa; }
</style>

@endsection
