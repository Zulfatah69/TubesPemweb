<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Midtrans\Snap;
use Midtrans\Config;

class BookingPaymentController extends Controller
{
    public function pay($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Jika sudah dibayar
        if ($booking->payment_status === 'paid') {
            return redirect()
                ->route('user.booking.my')
                ->with('success', 'Booking ini sudah dibayar.');
        }

        // Jika snap token sudah ada (belum dibayar)
        if ($booking->snap_token && $booking->order_id) {
            return view('user.bookings.pay', [
                'booking'   => $booking,
                'snapToken' => $booking->snap_token,
            ]);
        }

        // Konfigurasi Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // Order ID unik
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

        // Request Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Simpan ke database (PAKAI payment_status, BUKAN status)
        $booking->update([
            'order_id'        => $orderId,
            'snap_token'      => $snapToken,
            'payment_status' => 'unpaid',
        ]);

        return view('user.bookings.pay', [
            'booking'   => $booking,
            'snapToken' => $snapToken,
        ]);
    }
}
