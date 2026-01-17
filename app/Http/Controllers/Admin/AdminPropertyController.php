<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPropertyController extends Controller
{
    // List all properties (optional jika tidak dipakai)
    public function index()
    {
        $properties = Property::latest()->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    // Delete property
    public function destroy(Property $property)
    {
        // Hapus semua file gambar dari storage
        foreach ($property->images as $img) {
            if ($img->file_path && Storage::disk('public')->exists($img->file_path)) {
                Storage::disk('public')->delete($img->file_path);
            }
        }

        // Hapus record images di DB
        $property->images()->delete();

        // Hapus properti
        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus');
    }
}
