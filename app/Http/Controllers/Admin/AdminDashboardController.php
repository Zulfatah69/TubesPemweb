<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers  = User::where('role', 'user')->count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalProperties = Property::count();
        $totalBookings   = Booking::count();

        $bookingStats = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartLabels = [];
        $chartData   = [];

        foreach ($bookingStats as $row) {
            $chartLabels[] = date('M', mktime(0,0,0,$row->month,1));
            $chartData[]   = $row->total;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOwners',
            'totalAdmins',
            'totalProperties',
            'totalBookings',
            'chartLabels',
            'chartData'
        ));
    }

    public function properties(User $user)
    {
        if ($user->role !== 'owner') {
            abort(404);
        }

        $properties = Property::with(['images'])
            ->withCount('bookings')
            ->where('owner_id', $user->id)
            ->latest()
            ->get();

        return view('admin.users.properties', compact('user', 'properties'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'property'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function destroyProperty(Property $property)
    {
        $property->load('images');

        foreach ($property->images as $img) {
            if ($img->file_path && Storage::disk('public')->exists($img->file_path)) {
                Storage::disk('public')->delete($img->file_path);
            }
            $img->delete();
        }

        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus');
    }
}
