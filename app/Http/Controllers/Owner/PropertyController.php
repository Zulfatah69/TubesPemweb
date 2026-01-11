<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Throwable;

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
            'name' => ['required'],
            'location' => ['required'],
            'price' => ['required','numeric'],
            'description' => ['nullable'],
            'province' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'address' => ['nullable'],
            'gender_type' => ['required', 'in:putra,putri,campuran'],
            'facilities' => ['array'],
            'custom_facilities' => ['nullable'],
            'photos.*' => ['image','max:2048']
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

        $this->handleUploadPhotos($request, $property);

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
            'city' => $request->filled('city') ? $request->city : $property->city,
            'district' => $request->filled('district') ? $request->district : $property->district,
        ]);

        $request->validate([
            'name' => ['required'],
            'location' => ['required'],
            'price' => ['required','numeric'],
            'description' => ['nullable'],
            'province' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'address' => ['nullable'],
            'gender_type' => ['required', 'in:putra,putri,campuran'],
            'facilities' => ['array'],
            'custom_facilities' => ['nullable'],
            'photos.*' => ['image','max:2048']
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

        $this->handleUploadPhotos($request, $property);

        return back()->with('success','Properti diperbarui');
    }

    private function handleUploadPhotos(Request $request, Property $property)
    {
        if (!$request->hasFile('photos')) return;

        foreach ($request->file('photos') as $index => $photo) {

            try {

                if (!env('CLOUDINARY_URL')) {
                    logger()->error('Cloudinary URL not set');
                    continue;
                }

                $uploaded = Cloudinary::upload(
                    $photo->getRealPath(),
                    [
                        'folder' => 'properties',
                        'resource_type' => 'image'
                    ]
                );

                $url = $uploaded->getSecurePath();

                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path' => $url,
                    'is_main' => $property->images()->count() === 0 && $index === 0
                ]);

            } catch (Throwable $e) {

                logger()->error('Cloudinary upload failed', [
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function deleteImage(PropertyImage $image)
    {
        $property = $image->property;
        if ($property->owner_id !== Auth::id()) abort(403);

        $publicId = $this->extractPublicId($image->file_path);

        if ($publicId && env('CLOUDINARY_URL')) {
            try {
                Cloudinary::destroy($publicId);
            } catch (Throwable $e) {}
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

        PropertyImage::where('property_id', $property->id)->update(['is_main' => false]);
        $image->update(['is_main' => true]);

        return back()->with('success','Foto utama berhasil diubah');
    }

    public function destroy(Property $property)
    {
        if ($property->owner_id !== Auth::id()) abort(403);

        foreach ($property->images as $image) {

            $publicId = $this->extractPublicId($image->file_path);

            if ($publicId && env('CLOUDINARY_URL')) {
                try {
                    Cloudinary::destroy($publicId);
                } catch (Throwable $e) {}
            }

            $image->delete();
        }

        $property->delete();

        return redirect()->route('owner.properties.index')
            ->with('success', 'Properti berhasil dihapus');
    }

    private function extractPublicId($url)
    {
        if (!$url) return null;

        $path = parse_url($url, PHP_URL_PATH);
        $filename = pathinfo($path, PATHINFO_FILENAME);

        return 'properties/' . $filename;
    }
}
