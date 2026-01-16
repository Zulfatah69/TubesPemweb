<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
    // Daftar owner
    public function index()
    {
        $owners = User::where('role', 'owner')
            ->where('id', '!=', Auth::id())
            ->get();

        return view('chat.user_list', compact('owners'));
    }

    // Chat dengan owner tertentu
    public function show(User $owner)
    {
        $user = Auth::user();

        if ($owner->id === $user->id) abort(404);

        $chat = Chat::where(function($q) use ($user, $owner) {
            $q->where('user_id', $user->id)->where('owner_id', $owner->id);
        })->orWhere(function($q) use ($user, $owner) {
            $q->where('user_id', $owner->id)->where('owner_id', $user->id);
        })->first(); // ambil 1 chat aja

        return view('chat.user', compact('owner', 'chat'));
    }

    // Kirim pesan
    public function send(User $owner, Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'message' => 'required|string|max:2000',
            'property_id' => 'required|integer'
        ]);

        // Ambil atau buat chat
        $chat = Chat::firstOrCreate([
            'user_id' => $user->id,
            'owner_id'=> $owner->id,
            'property_id' => $data['property_id'],
        ]);

        // Simpan pesan
        $chat->messages()->create([
            'sender_id' => $user->id,
            'message' => $data['message'],
        ]);

        return response()->json(['status' => 'success']);
    }
}
