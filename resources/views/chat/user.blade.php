@extends('layouts.app')

@section('content')

<h4 class="mb-3">
    Chat dengan Pemilik – {{ $chat->property->name }}
</h4>

<div class="card">
    <div class="card-body" id="chat-box" style="height: 400px; overflow-y: auto;">
        @forelse($chat->messages as $msg)
            <div class="mb-2 {{ $msg->sender_id == auth()->id() ? 'text-end' : '' }}">
                <div class="d-inline-block p-2 rounded
                    {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}">
                    {{ $msg->message }}
                </div>
                <div class="small text-muted">
                    {{ $msg->created_at->format('H:i') }}
                </div>
            </div>
        @empty
            <p class="text-muted text-center">Belum ada pesan</p>
        @endforelse
    </div>

    <div class="card-footer">
        <form method="POST" action="{{ route('chat.send', $chat->id) }}">
            @csrf
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required>
                <button class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');

    function loadMessages() {
        fetch("{{ route('chat.messages', $chat->id) }}")
            .then(res => res.json())
            .then(data => {
                chatBox.innerHTML = '';

                data.forEach(msg => {
                    const isMe = msg.sender_id === {{ auth()->id() }};
                    const wrapper = document.createElement('div');
                    wrapper.className = 'mb-2 ' + (isMe ? 'text-end' : '');

                    wrapper.innerHTML = `
                        <div class="d-inline-block p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'}">
                            ${msg.message}
                        </div>
                        <div class="small text-muted">
                            ${new Date(msg.created_at).toLocaleTimeString()}
                        </div>
                    `;

                    chatBox.appendChild(wrapper);
                });

                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    loadMessages();
    setInterval(loadMessages, 5000);
</script>

@endsection
