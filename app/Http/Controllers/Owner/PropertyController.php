<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('owner_id', Auth::id())
            ->latest()
            ->get();

        return view('owner.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('owner.properties.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateProperty($request);

        $property = Property::create(array_merge($data, [
            'owner_id' => Auth::id(),
        ]));

        $this->uploadPhotos($request, $property);

        return redirect()->route('owner.properties.index')
            ->with('success', 'Properti ditambahkan');
    }

    public function edit(Property $property)
    {
        $this->authorizeOwner($property);

        $property->load('images');
        return view('owner.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorizeOwner($property);

        $data = $this->validateProperty($request);
        $property->update($data);

        $this->uploadPhotos($request, $property);

        return back()->with('success', 'Properti diperbarui');
    }

    public function destroy(Property $property)
    {
        $this->authorizeOwner($property);

        foreach ($property->images as $image) {
            $file = public_path($image->file_path);
            if (file_exists($file)) {
                unlink($file);
            }
            $image->delete();
        }

        $property->delete();

        return redirect()->route('owner.properties.index')
            ->with('success', 'Properti dihapus');
    }

    private function uploadPhotos(Request $request, Property $property)
    {
        if (!$request->hasFile('photos')) return;

        $existingCount = $property->images()->count();

        $uploadPath = public_path('uploads/properties');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($request->file('photos') as $index => $photo) {

            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($uploadPath, $filename);

            PropertyImage::create([
                'property_id' => $property->id,
                'file_path' => 'uploads/properties/' . $filename,
                'is_main' => ($existingCount === 0 && $index === 0),
            ]);
        }
    }

    public function deleteImage(PropertyImage $image)
    {
        $property = $image->property;
        $this->authorizeOwner($property);

        $file = public_path($image->file_path);
        if (file_exists($file)) {
            unlink($file);
        }

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
        $this->authorizeOwner($property);

        PropertyImage::where('property_id', $property->id)
            ->update(['is_main' => false]);

        $image->update(['is_main' => true]);

        return back()->with('success', 'Foto utama diubah');
    }

    private function validateProperty(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'address' => 'nullable|string',
            'gender_type' => 'required|in:putra,putri,campuran',
            'facilities' => 'nullable|array',
            'custom_facilities' => 'nullable|string',
            'description' => 'nullable|string',
            'photos.*' => 'nullable|image|max:2048',
        ]);
    }

    private function authorizeOwner(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);
    }
}
