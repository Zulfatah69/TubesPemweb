<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class AdminPropertyController extends Controller
{
    // List all properties
    public function index()
    {
        $properties = Property::all();
        return view('admin.properties.index', compact('properties'));
    }

    // Show form create
    public function create()
    {
        return view('admin.properties.create');
    }

    // Store new property
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'location' => 'required|string',
        ]);

        Property::create($request->all());

        return redirect()->route('admin.properties.index')
            ->with('success', 'Properti berhasil ditambahkan');
    }

    // Edit property
    public function edit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    // Update property
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'location' => 'required|string',
        ]);

        $property->update($request->all());

        return redirect()->route('admin.properties.index')
            ->with('success', 'Properti berhasil diperbarui');
    }

    // Delete property
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index')
            ->with('success', 'Properti berhasil dihapus');
    }
}
