<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * LIST SEMUA CHAT USER
     * /user/chats
     */
    public function index()
    {
        $user = Auth::user();

        $chats = Chat::with(['property', 'owner'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('chat.user_list', compact('chats'));
    }

    /**
     * Mulai chat dari halaman property (USER)
     */
    public function start(Property $property)
    {
        $user = Auth::user();

        $ownerId = $property->owner_id;

        $chat = Chat::where('property_id', $property->id)
            ->where('user_id', $user->id)
            ->where('owner_id', $ownerId)
            ->first();

        if (! $chat) {
            $chat = Chat::create([
                'property_id' => $property->id,
                'user_id'     => $user->id,
                'owner_id'    => $ownerId,
            ]);
        }

        return redirect()->route('chat.show', $chat->id);
    }

    /**
     * Tampilkan chat (USER)
     */
    public function show(Chat $chat)
    {
        $user = Auth::user();

        if ($chat->user_id !== $user->id) {
            abort(403);
        }

        $chat->load(['messages.sender', 'property']);

        return view('chat.user', compact('chat'));
    }

    /**
     * Kirim pesan (USER)
     */
    public function send(Request $request, Chat $chat)
    {
        $user = Auth::user();

        if ($chat->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $user->id,
            'message'   => $request->message,
        ]);

        return back();
    }

    /**
     * AMBIL PESAN (AUTO-REFRESH / POLLING)
     * Dipakai USER & OWNER
     */
    public function messages(Chat $chat)
    {
        $user = Auth::user();

        if ($chat->user_id !== $user->id && $chat->owner_id !== $user->id) {
            abort(403);
        }

        return response()->json(
            $chat->messages()
                ->with('sender')
                ->latest()
                ->get()
                ->reverse()
                ->values()
        );
    }
}
