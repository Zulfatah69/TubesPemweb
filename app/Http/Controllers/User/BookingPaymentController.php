<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class BookingPaymentController extends Controller
{
    public function pay($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status === 'paid') {
            return redirect()
                ->route('user.booking.my')
                ->with('success', 'Booking ini sudah dibayar.');
        }

        if ($booking->snap_token && $booking->order_id) {
            return view('user.bookings.pay', [
                'booking'   => $booking,
                'snapToken' => $booking->snap_token,
            ]);
        }

        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $orderId = 'BOOKING-' . $booking->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $booking->update([
            'order_id'   => $orderId,
            'snap_token' => $snapToken,
            'status'     => 'unpaid',
        ]);

        return view('user.bookings.pay', [
            'booking'   => $booking,
            'snapToken' => $snapToken,
        ]);
    }
}
