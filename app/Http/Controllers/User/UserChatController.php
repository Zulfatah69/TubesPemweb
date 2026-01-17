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

    public function show(User $owner)
    {
        $user = Auth::user();

        if ($owner->id === $user->id) abort(404);

        $chat = Chat::where(function ($q) use ($user, $owner) {
            $q->where('user_id', $user->id)->where('owner_id', $owner->id);
        })->orWhere(function ($q) use ($user, $owner) {
            $q->where('user_id', $owner->id)->where('owner_id', $user->id);
        })->first();

        return view('chat.user', compact('owner', 'chat'));
    }

    public function send(User $owner, Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'message' => 'required|string|max:2000',
            'property_id' => 'required|integer'
        ]);

        $chat = Chat::firstOrCreate([
            'user_id' => $user->id,
            'owner_id' => $owner->id,
            'property_id' => $data['property_id'],
        ]);

        $chat->messages()->create([
            'sender_id' => $user->id,
            'message' => $data['message'],
        ]);

        return response()->json(['status' => 'success']);
    }

    public function messages(User $owner)
    {
        $user = Auth::user();

        $chat = Chat::where(function ($q) use ($user, $owner) {
            $q->where('user_id', $user->id)->where('owner_id', $owner->id);
        })->orWhere(function ($q) use ($user, $owner) {
            $q->where('user_id', $owner->id)->where('owner_id', $user->id);
        })->first();

        if (!$chat) return response()->json([]);

        return response()->json($chat->messages()->with('sender')->get());
    }

    public function start(User $owner, Request $request)
    {
        $propertyId = $request->input('property_id');

        $chat = Chat::firstOrCreate([
            'user_id' => auth()->id(),
            'owner_id' => $owner->id,
            'property_id' => $propertyId,
        ]);

        return redirect()->route('user.chats.show', $owner->id);
    }
}
