<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminOwnerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'owner');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        $owners = $query->withCount('properties')
                        ->latest()
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.owners.index', compact('owners'));
    }

    public function properties(User $owner)
    {
        if ($owner->role !== 'owner') abort(404);

        $properties = Property::with('images')
            ->where('owner_id', $owner->id)
            ->latest()
            ->paginate(10);

        return view('admin.owners.properties', compact('owner', 'properties'));
    }

    public function toggleBlock(User $owner)
    {
        if ($owner->role !== 'owner') abort(404);

        $owner->update([
            'is_blocked' => !$owner->is_blocked
        ]);

        return back()->with('success', 'Status owner diperbarui');
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
}
