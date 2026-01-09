@extends('layouts.app')

@section('content')

<h4 class="mb-3">Daftar Chat</h4>

<div class="list-group">
    @forelse($chats as $chat)
        <a href="{{ route('owner.chat.show', $chat->id) }}" class="list-group-item list-group-item-action">
            <strong>{{ $chat->user->name }}</strong><br>
            <small class="text-muted">{{ $chat->property->name }}</small>
        </a>
    @empty
        <p class="text-muted">Belum ada chat</p>
    @endforelse
</div>

@endsection
