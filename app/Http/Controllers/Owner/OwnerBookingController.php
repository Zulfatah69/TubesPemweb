<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class OwnerBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::whereHas('property', function($q){
            $q->where('owner_id', Auth::id());
        })
        ->with(['user','property'])
        ->latest()
        ->get();

        return view('owner.bookings.index', compact('bookings'));
    }


    public function updateStatus(Booking $booking, $status)
    {
        if(!in_array($status,['approved','rejected'])){
            abort(400);
        }

        // keamanan → pastikan ownernya sama
        if($booking->property->owner_id != Auth::id()){
            abort(403);
        }

        $booking->update([
            'status' => $status
        ]);

        return back()->with('success','Status booking diperbarui');
    }
}
