<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Chat;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $chats = Chat::with(['owner', 'property'])
            ->where('user_id', $userId)
            ->orWhere('owner_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('chat.user_list', compact('chats'));
    }

    public function show(Chat $chat)
    {
        $user = auth()->user();

        if ($chat->user_id !== $user->id) {
            abort(403);
        }

        $chat->load(['messages.sender', 'owner', 'property']);

        return view('chat.user', compact('chat'));
    }

    public function send(Chat $chat, Request $request)
    {
        $user = auth()->user();

        if ($chat->user_id !== $user->id) abort(403);

        $data = $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $chat->messages()->create([
            'sender_id' => $user->id,
            'message' => $data['message'],
        ]);

        $chat->touch();

        return response()->json(['status' => 'success']);
    }

    public function messages(Chat $chat)
    {
        $user = auth()->user();

        if ($chat->user_id !== $user->id) abort(403);

        return response()->json(
            $chat->messages()->with('sender')->orderBy('id')->get()
        );
    }

    public function start(User $owner, Request $request)
    {
        $propertyId = $request->input('property_id');

        $chat = Chat::firstOrCreate([
            'user_id' => auth()->id(),
            'owner_id' => $owner->id,
            'property_id' => $propertyId,
        ]);

        return redirect()->route('user.chats.show', $chat->id);
    }
}
