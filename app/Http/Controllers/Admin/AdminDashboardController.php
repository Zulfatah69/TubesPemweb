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
    /**
     * Dashboard utama admin
     */
    public function index()
    {
        // Hitung total user berdasarkan role
        $totalUsers  = User::where('role', 'user')->count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Hitung total properti & booking
        $totalProperties = Property::count();
        $totalBookings   = Booking::count();

        // ===== Chart Booking per Bulan =====
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: gunakan strftime
            $bookingStats = DB::table('bookings')
                ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            // MySQL / lainnya
            $bookingStats = DB::table('bookings')
                ->selectRaw("MONTH(created_at) as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        $chartLabels = [];
        $chartData   = [];

        foreach ($bookingStats as $row) {
            $month = (int)$row->month; // SQLite strftime ngasih string
            $chartLabels[] = date('M', mktime(0,0,0,$month,1));
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

    /**
     * Tampilkan properti milik user (owner)
     */
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

    /**
     * List semua booking
     */
    public function bookings()
    {
        $bookings = Booking::with(['user', 'property'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Hapus properti + semua gambar terkait
     */
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
