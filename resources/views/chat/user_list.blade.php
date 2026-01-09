@extends('layouts.app')

@section('content')

<h4 class="mb-3">💬 Chat Saya</h4>

<div class="list-group">
    @forelse($chats as $chat)
        <a href="{{ route('chat.show', $chat->id) }}"
           class="list-group-item list-group-item-action">
            <strong>{{ $chat->property->name }}</strong><br>
            <small class="text-muted">
                Pemilik: {{ $chat->owner->name }}
            </small>
        </a>
    @empty
        <div class="alert alert-info">
            Kamu belum memiliki chat dengan pemilik kos.
        </div>
    @endforelse
</div>

@endsection
