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

<<<<<<< HEAD
=======
            // ✅ KATEGORI KOS
            'gender_type' => ['required', 'in:putra,putri,campuran'],

>>>>>>> zulfatah
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

<<<<<<< HEAD
=======
            // ✅ SIMPAN KATEGORI
            'gender_type' => $request->gender_type,

>>>>>>> zulfatah
            'facilities' => $request->facilities ?? [],
            'custom_facilities' => $request->custom_facilities
                ? explode(',', $request->custom_facilities)
                : [],
        ]);

<<<<<<< HEAD
        if($request->hasFile('photos')){
            foreach($request->file('photos') as $index => $photo){
                $path = $photo->store('properties','public');
=======
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('properties', 'public');
>>>>>>> zulfatah

                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path' => $path,
                    'is_main' => $index === 0
                ]);
            }
        }

        return redirect()->route('owner.properties.index')
            ->with('success','Properti ditambahkan');
    }

    public function edit(Property $property)
    {
<<<<<<< HEAD
        if($property->owner_id !== Auth::id()) abort(403);
=======
        if ($property->owner_id !== Auth::id()) abort(403);
>>>>>>> zulfatah

        $property->load('images');

        return view('owner.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
<<<<<<< HEAD
        if($property->owner_id !== Auth::id()) abort(403);
=======
        if ($property->owner_id !== Auth::id()) abort(403);
>>>>>>> zulfatah

        $request->validate([
            'name'      => ['required'],
            'location'  => ['required'],
            'price'     => ['required','numeric'],
            'description' => ['nullable'],

            'province'  => ['required'],
            'city'      => ['required'],
            'district'  => ['required'],
            'address'   => ['nullable'],

<<<<<<< HEAD
=======
            // ✅ KATEGORI KOS
            'gender_type' => ['required', 'in:putra,putri,campuran'],

>>>>>>> zulfatah
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

<<<<<<< HEAD
=======
            // ✅ UPDATE KATEGORI
            'gender_type' => $request->gender_type,

>>>>>>> zulfatah
            'facilities' => $request->facilities ?? [],
            'custom_facilities' => $request->custom_facilities
                ? explode(',', $request->custom_facilities)
                : [],
        ]);

<<<<<<< HEAD
        if($request->hasFile('photos')){
            foreach($request->file('photos') as $photo){
                $path = $photo->store('properties','public');
=======
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('properties', 'public');
>>>>>>> zulfatah

                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path' => $path
                ]);
            }
        }

        return back()->with('success','Properti diperbarui');
    }

    public function deleteImage(PropertyImage $image)
    {
        $property = $image->property;

<<<<<<< HEAD
        if($property->owner_id !== Auth::id()){
            abort(403);
        }

        if(Storage::disk('public')->exists($image->file_path)){
=======
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($image->file_path)) {
>>>>>>> zulfatah
            Storage::disk('public')->delete($image->file_path);
        }

        $wasMain = $image->is_main;
<<<<<<< HEAD

        $image->delete();

        if($wasMain){
            $newMain = PropertyImage::where('property_id',$property->id)->first();
            if($newMain){
=======
        $image->delete();

        if ($wasMain) {
            $newMain = PropertyImage::where('property_id', $property->id)->first();
            if ($newMain) {
>>>>>>> zulfatah
                $newMain->update(['is_main' => true]);
            }
        }

        return back()->with('success','Foto berhasil dihapus');
    }

<<<<<<< HEAD
    // ==========================
    // SET FOTO UTAMA
    // ==========================
=======
>>>>>>> zulfatah
    public function setMain(PropertyImage $image)
    {
        $property = $image->property;

<<<<<<< HEAD
        if($property->owner_id !== Auth::id()){
            abort(403);
        }

        // reset semua ke 0
        PropertyImage::where('property_id', $property->id)
            ->update(['is_main' => false]);

        // set foto terpilih jadi utama
=======
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        PropertyImage::where('property_id', $property->id)
            ->update(['is_main' => false]);

>>>>>>> zulfatah
        $image->update(['is_main' => true]);

        return back()->with('success','Foto utama berhasil diubah');
    }
}
