<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();

        $total_properties = Property::where('owner_id', $ownerId)->count();

        $total_bookings = Booking::whereHas('property', function($q) use ($ownerId){
            $q->where('owner_id', $ownerId);
        })->count();

        $pending_bookings = Booking::whereHas('property', function($q) use ($ownerId){
            $q->where('owner_id', $ownerId);
        })->where('status','pending')->count();

        return view('owner.dashboard', compact(
            'total_properties',
            'total_bookings',
            'pending_bookings'
        ));
    }
}

