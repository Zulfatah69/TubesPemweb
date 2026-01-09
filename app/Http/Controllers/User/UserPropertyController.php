<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class UserPropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['images' => function($q){
            $q->where('is_main', true);
        }]);

        if($request->province){
            $query->where('province', $request->province);
        }

        if($request->city){
            $query->where('city', $request->city);
        }

        if($request->district){
            $query->where('district', $request->district);
        }

        if($request->max_price){
            $query->where('price','<=',$request->max_price);
        }

        if($request->has('facility')){
            foreach($request->facility as $f){
                $query->whereJsonContains('facilities', $f);
            }
        }
        
        if ($request->gender_type) {
            $query->where('gender_type', $request->gender_type);
        }


        $properties = $query->latest()->get();

        return view('user.properties.index', compact('properties'));
    }


    public function show(Property $property)
    {
        // ambil semua foto
        $property->load('images');

        return view('user.properties.show', compact('property'));
    }
}
