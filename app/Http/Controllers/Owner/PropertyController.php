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
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'gender_type' => 'required|in:putra,putri,campuran',
            'photos.*' => 'image|max:2048',
        ]);

        $property = Property::create([
            'owner_id' => Auth::id(),
            'name' => $request->name,
            'location' => $request->location,
            'price' => $request->price,
            'description' => $request->description,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'address' => $request->address,
            'gender_type' => $request->gender_type,
            'facilities' => $request->facilities ?? [],
            'custom_facilities' => $request->custom_facilities ? explode(',', $request->custom_facilities) : [],
        ]);

        $this->uploadPhotos($request, $property);

        return redirect()->route('owner.properties.index')->with('success', 'Properti ditambahkan');
    }

    public function edit(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);
        $property->load('images');
        return view('owner.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'gender_type' => 'required|in:putra,putri,campuran',
            'photos.*' => 'image|max:2048',
        ]);

        $property->update([
            'name' => $request->name,
            'location' => $request->location,
            'price' => $request->price,
            'description' => $request->description,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'address' => $request->address,
            'gender_type' => $request->gender_type,
            'facilities' => $request->facilities ?? [],
            'custom_facilities' => $request->custom_facilities ? explode(',', $request->custom_facilities) : [],
        ]);

        $this->uploadPhotos($request, $property);

        return back()->with('success', 'Properti diperbarui');
    }

    private function uploadPhotos(Request $request, Property $property)
    {
        if (!$request->hasFile('photos')) return;

        $existingCount = $property->images()->count();

        foreach ($request->file('photos') as $index => $photo) {

            $path = $photo->store('properties', 'public'); // storage/app/public/properties

            PropertyImage::create([
                'property_id' => $property->id,
                'file_path' => $path,
                'is_main' => ($existingCount === 0 && $index === 0),
            ]);
        }
    }

    public function deleteImage(PropertyImage $image)
    {
        $property = $image->property;
        abort_if($property->owner_id !== Auth::id(), 403);

        Storage::disk('public')->delete($image->file_path);

        $wasMain = $image->is_main;
        $image->delete();

        if ($wasMain) {
            PropertyImage::where('property_id', $property->id)
                ->first()?->update(['is_main' => true]);
        }

        return back()->with('success', 'Foto berhasil dihapus');
    }

    public function setMain(PropertyImage $image)
    {
        $property = $image->property;
        abort_if($property->owner_id !== Auth::id(), 403);

        PropertyImage::where('property_id', $property->id)->update(['is_main' => false]);
        $image->update(['is_main' => true]);

        return back()->with('success', 'Foto utama diubah');
    }

    public function destroy(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->file_path);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('owner.properties.index')->with('success', 'Properti dihapus');
    }
}
