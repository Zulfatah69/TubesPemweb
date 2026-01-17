<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class UserPropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('images');

        // FILTER LOKASI
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        // FILTER HARGA
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // FILTER KATEGORI
        if ($request->filled('gender_type')) {
            $query->where('gender_type', $request->gender_type);
        }

        // FILTER FASILITAS (JSON)
        if ($request->filled('facility') && is_array($request->facility)) {
            foreach ($request->facility as $facility) {
                $query->whereJsonContains('facilities', $facility);
            }
        }

        $properties = $query->latest()->get();

        return view('user.properties.index', compact('properties'));
    }

    public function show($id)
    {
        $property = Property::with('images')->findOrFail($id);

        return view('user.properties.show', compact('property'));
    }
}
