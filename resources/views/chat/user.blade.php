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
                            <h6 class="fw-bold mb-0 text-dark">{{ $chat->owner->name }}</h6>
                            {{-- Info Properti --}}
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-building-fill me-1 text-secondary"></i> {{ $chat->property->name }}
                            </small>
                        </div>
                    </div>
                    
                    {{-- Harga Kos (Info Cepat) --}}
                    <div class="text-end d-none d-sm-block">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            Rp {{ number_format($chat->property->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- BODY CHAT --}}
                <div class="card-body bg-light p-4" id="chat-box" style="overflow-y: auto; display: flex; flex-direction: column;">
                    
                    @forelse($chat->messages as $msg)
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
                    <form id="chat-form" method="POST" action="{{ route('chat.send', $chat->id) }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" id="message-input" class="form-control border-0 bg-light rounded-pill px-4" placeholder="Tulis pesan..." required autocomplete="off">
                            <button class="btn btn-primary rounded-circle ms-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                <i class="bi bi-send-fill"></i>
                            </button>
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
    
    // Auto scroll ke bawah saat load
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollToBottom();

    // Fetch pesan real-time (Polling)
    function loadMessages() {
        fetch("{{ route('chat.messages', $chat->id) }}")
            .then(res => res.json())
            .then(data => {
                const currentScroll = chatBox.scrollTop;
                const maxScroll = chatBox.scrollHeight - chatBox.clientHeight;
                const isAtBottom = maxScroll - currentScroll < 50;

                chatBox.innerHTML = ''; 

                if(data.length === 0) {
                    chatBox.innerHTML = '<p class="text-muted text-center mt-5">Belum ada pesan</p>';
                    return;
                }

                data.forEach(msg => {
                    const isMe = msg.sender_id == authId;
                    
                    const bubbleHtml = `
                        <div class="d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}">
                            <div class="p-3 shadow-sm ${isMe ? 'bg-primary text-white rounded-end-top-0' : 'bg-white text-dark rounded-start-top-0'}" 
                                 style="max-width: 75%; border-radius: 15px;">
                                <div class="mb-1">${escapeHtml(msg.message)}</div>
                                <div class="text-end" style="font-size: 0.65rem; opacity: 0.7;">
                                    ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                </div>
                            </div>
                        </div>
                    `;
                    chatBox.insertAdjacentHTML('beforeend', bubbleHtml);
                });

                if (isAtBottom) {
                    scrollToBottom();
                }
            });
    }

    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Update setiap 3 detik
    setInterval(loadMessages, 3000);

    // Kirim pesan tanpa reload (AJAX)
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const input = document.getElementById('message-input');
        const message = input.value;
        if(!message.trim()) return;

        input.value = ''; // Kosongkan input segera agar responsif

        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(() => {
            loadMessages();
            setTimeout(scrollToBottom, 300); // Pastikan scroll setelah pesan muncul
        });
    });
</script>

<style>
    /* Custom Scrollbar */
    #chat-box::-webkit-scrollbar { width: 6px; }
    #chat-box::-webkit-scrollbar-track { background: #f1f1f1; }
    #chat-box::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    #chat-box::-webkit-scrollbar-thumb:hover { background: #aaa; }
</style>

@endsection