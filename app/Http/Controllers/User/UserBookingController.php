<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'start_date' => ['required','date'],
            'note' => ['nullable']
        ]);

        $exists = Booking::where('user_id', Auth::id())
            ->where('property_id', $property->id)
            ->whereIn('status',['pending','approved'])
            ->exists();

        if($exists){
            return back()->with('error',
                'Anda sudah memiliki booking aktif pada properti ini');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $property->id,
            'start_date' => $request->start_date,
            'note' => $request->note,
            'status' => 'pending'
        ]);

        return back()->with('success','Booking berhasil dikirim');
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('property')
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }
}
