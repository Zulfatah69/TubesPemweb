<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    /**
     * SIMPAN BOOKING USER
     */
    public function store(Request $request, Property $property)
    {
        $request->validate(
            [
                'start_date' => 'required|date',
                'months'     => 'nullable|integer|min:1',
                'note'       => 'nullable|string',
            ],
            [
                'start_date.required' => 'Tanggal mulai wajib diisi',
                'start_date.date'     => 'Format tanggal tidak valid',
                'months.min'          => 'Minimal sewa 1 bulan',
            ]
        );

        // default sewa 1 bulan
        $months = $request->months ?? 1;

        // ❌ Cegah booking ganda
        $exists = Booking::where('user_id', Auth::id())
            ->where('property_id', $property->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->with(
                'error',
                'Anda sudah memiliki booking aktif pada properti ini'
            );
        }

        // 💰 HITUNG TOTAL HARGA
        $totalPrice = $property->price * $months;

        // ✅ SIMPAN BOOKING
        Booking::create([
            'user_id'        => Auth::id(),
            'property_id'    => $property->id,
            'start_date'     => $request->start_date,
            'months'         => $months,
            'total_price'    => $totalPrice,
            'note'           => $request->note,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()
            ->route('user.booking.my')
            ->with('success', 'Booking berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    /**
     * LIST BOOKING USER
     */
    public function myBookings()
    {
        $bookings = Booking::with('property')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }
}
