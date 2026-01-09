<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class BookingPaymentController extends Controller
{
    public function pay(Booking $booking)
    {
        // SECURITY
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('user.booking.my')
                ->with('success', 'Booking sudah dibayar');
        }

        // MIDTRANS CONFIG
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');

        // ORDER ID UNIK
        if (!$booking->midtrans_order_id) {
            $booking->update([
                'midtrans_order_id' => 'BOOK-' . $booking->id . '-' . time(),
            ]);
        }

        // PARAM MIDTRANS
        $params = [
            'transaction_details' => [
                'order_id'     => $booking->midtrans_order_id,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email'      => $booking->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $booking->update([
            'snap_token' => $snapToken,
        ]);

        return view('user.bookings.pay', compact('booking', 'snapToken'));
    }
}
