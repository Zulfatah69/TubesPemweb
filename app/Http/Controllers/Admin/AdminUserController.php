<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['user', 'owner']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:owner,user'
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }
    
    public function block(User $user)
    {
    // Admin tidak bisa diblokir (opsional)
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak bisa diblokir.');
    }

    // Toggle blocked: 0 → 1 atau 1 → 0
    $user->blocked = !$user->blocked;
    $user->save();

    return back()->with('success', 'Status blokir berhasil diubah.');
    }


    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat dihapus');
        }

        // Hapus properti & gambar jika owner
        if ($user->role === 'owner') {
            $properties = Property::with('images')->where('owner_id', $user->id)->get();

            foreach ($properties as $property) {
                foreach ($property->images as $img) {
                    if ($img->file_path && Storage::disk('public')->exists($img->file_path)) {
                        Storage::disk('public')->delete($img->file_path);
                    }
                    $img->delete();
                }

                $property->delete();
            }
        }

        // Hapus booking user
        Booking::where('user_id', $user->id)->delete();

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }

    public function toggleBlock(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat diblokir');
        }

        $user->update([
            'is_blocked' => ! $user->is_blocked
        ]);

        return back()->with('success', 'Status user diperbarui');
    }

    public function properties(User $user)
    {
        if ($user->role !== 'owner') {
            abort(404);
        }

        $properties = Property::with('images')
            ->where('owner_id', $user->id)
            ->latest()
            ->get();

        return view('admin.users.properties', compact('user', 'properties'));
    }

    public function destroyProperty(Property $property)
    {
        $property->load('images');

        foreach ($property->images as $img) {
            if ($img->file_path && Storage::disk('public')->exists($img->file_path)) {
                Storage::disk('public')->delete($img->file_path);
            }
            $img->delete();
        }

        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus');
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'property'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }
    
}
