<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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


    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return redirect()
            ->route('owner.booking.index')
            ->with('success', 'Status booking berhasil diperbarui');
    }
}
