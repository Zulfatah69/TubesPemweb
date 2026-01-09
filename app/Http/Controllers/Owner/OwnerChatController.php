<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerChatController extends Controller
{
    /**
     * List semua chat owner
     */
    public function index()
    {
        $owner = Auth::user();

        $chats = Chat::with(['property', 'user'])
            ->where('owner_id', $owner->id)
            ->latest()
            ->get();

        return view('chat.owner_list', compact('chats'));
    }

    /**
     * Tampilkan chat owner
     */
    public function show(Chat $chat)
    {
        $owner = Auth::user();

        if ($chat->owner_id !== $owner->id) {
            abort(403);
        }

        $chat->load(['messages.sender', 'property', 'user']);

        return view('chat.owner', compact('chat'));
    }

    /**
     * Kirim pesan owner
     */
    public function send(Request $request, Chat $chat)
    {
        $owner = Auth::user();

        if ($chat->owner_id !== $owner->id) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $owner->id,
            'message'   => $request->message,
        ]);

        return back();
    }
}
