<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

                $uploaded = Cloudinary::upload(
                    $photo->getRealPath(),
                    ['folder' => 'properties']
                );

                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path'  => $uploaded->getSecurePath(),
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

                $uploaded = Cloudinary::uploadFile(
                    $photo->getRealPath(),
                    [
                        'folder' => 'properties'
                    ]
                );

                $imageUrl = $uploaded->getSecurePath();
                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path'  => $uploaded->getSecurePath()
                ]);
            }
        }

        return back()->withInput()->with('success','Properti diperbarui');
    }

    public function deleteImage(PropertyImage $image)
    {
        $property = $image->property;
        if ($property->owner_id !== Auth::id()) abort(403);

        // Hapus dari Cloudinary
        $publicId = $this->extractPublicId($image->file_path);
        if ($publicId) {
            Cloudinary::destroy($publicId);
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
        if ($property->owner_id !== Auth::id()) abort(403);

        $property->load('images');

        foreach ($property->images as $image) {

            $publicId = $this->extractPublicId($image->file_path);
            if ($publicId) {
                Cloudinary::destroy($publicId);
            }

            $image->delete();
        }

        $property->delete();

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Properti berhasil dihapus');
    }

    private function extractPublicId($url)
    {
        if (!$url) return null;

        $path = parse_url($url, PHP_URL_PATH);
        $filename = pathinfo($path, PATHINFO_FILENAME);

        // folder/properties/filename
        return 'properties/' . $filename;
    }
}
