<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('owner_id', Auth::id())->latest()->get();
        return view('owner.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('owner.properties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required'],
            'location'  => ['required'],
            'price'     => ['required','numeric'],
            'description' => ['nullable'],

            'province'  => ['required'],
            'city'      => ['required'],
            'district'  => ['required'],
            'address'   => ['nullable'],

            'gender_type' => ['required', 'in:putra,putri,campuran'],

            'facilities' => ['array'],
            'custom_facilities' => ['nullable'],

            'photos.*'  => ['image','max:2048']
        ]);

        $property = Property::create([
            'owner_id' => Auth::id(),
            'name'     => $request->name,
            'location' => $request->location,
            'price'    => $request->price,
            'description' => $request->description,

            'province' => $request->province,
            'city'     => $request->city,
            'district' => $request->district,
            'address'  => $request->address,

            'gender_type' => $request->gender_type,

            'facilities' => $request->facilities ?? [],
            'custom_facilities' => $request->custom_facilities
                ? explode(',', $request->custom_facilities)
                : [],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path'  => $path,
                    'is_main'    => $index === 0
                ]);
            }
        }

        return redirect()->route('owner.properties.index')
            ->with('success','Properti ditambahkan');
    }

    public function edit(Property $property)
    {
        if ($property->owner_id !== Auth::id()) abort(403);

        $property->load('images');

        return view('owner.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        if ($property->owner_id !== Auth::id()) abort(403);

        // FIX FINAL: string kosong ("") dianggap tidak dikirim
        $request->merge([
            'province' => $request->filled('province') ? $request->province : $property->province,
            'city'     => $request->filled('city')     ? $request->city     : $property->city,
            'district' => $request->filled('district') ? $request->district : $property->district,
        ]);

        $request->validate([
            'name'      => ['required'],
            'location'  => ['required'],
            'price'     => ['required','numeric'],
            'description' => ['nullable'],

            'province'  => ['required'],
            'city'      => ['required'],
            'district'  => ['required'],
            'address'   => ['nullable'],

            'gender_type' => ['required', 'in:putra,putri,campuran'],

            'facilities' => ['array'],
            'custom_facilities' => ['nullable'],

            'photos.*'  => ['image','max:2048']
        ]);

        $property->update([
            'name'     => $request->name,
            'location' => $request->location,
            'price'    => $request->price,
            'description' => $request->description,

            'province' => $request->province,
            'city'     => $request->city,
            'district' => $request->district,
            'address'  => $request->address,

            'gender_type' => $request->gender_type,

            'facilities' => $request->facilities ?? [],
            'custom_facilities' => $request->custom_facilities
                ? explode(',', $request->custom_facilities)
                : [],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path'  => $path
                ]);
            }
        }

        return back()->withInput()->with('success','Properti diperbarui');
    }

    public function deleteImage(PropertyImage $image)
    {
        $property = $image->property;

        if ($property->owner_id !== Auth::id()) abort(403);

        if (Storage::disk('public')->exists($image->file_path)) {
            Storage::disk('public')->delete($image->file_path);
        }

        $wasMain = $image->is_main;
        $image->delete();

        if ($wasMain) {
            $newMain = PropertyImage::where('property_id', $property->id)->first();
            if ($newMain) {
                $newMain->update(['is_main' => true]);
            }
        }

        return back()->with('success','Foto berhasil dihapus');
    }

    public function setMain(PropertyImage $image)
    {
        $property = $image->property;

        if ($property->owner_id !== Auth::id()) abort(403);

        PropertyImage::where('property_id', $property->id)
            ->update(['is_main' => false]);

        $image->update(['is_main' => true]);

        return back()->with('success','Foto utama berhasil diubah');
    }
    public function destroy(Property $property)
    {
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        $property->load('images');

        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }
            $image->delete();
        }

        $property->delete();

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Properti berhasil dihapus');
    }

}

