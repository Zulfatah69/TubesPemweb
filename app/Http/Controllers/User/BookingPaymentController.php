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

        // 🔒 Kalau sudah dibayar
        if ($booking->payment_status === 'paid') {
            return redirect()
                ->route('user.bookings')
                ->with('success', 'Booking ini sudah dibayar.');
        }

        // ✅ JIKA SUDAH PERNAH BUAT SNAP TOKEN (BELUM DIBAYAR)
        if ($booking->snap_token && $booking->midtrans_order_id) {
            return view('user.bookings.pay', [
                'booking'   => $booking,
                'snapToken' => $booking->snap_token,
            ]);
        }

        /* ==============================
           KONFIGURASI MIDTRANS
        ============================== */
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // 🔑 ORDER ID HARUS UNIK
        $orderId = 'BOOK-' . $booking->id . '-' . time();

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

        // 🚀 REQUEST KE MIDTRANS (HANYA SEKALI)
        $snapToken = Snap::getSnapToken($params);

        // 💾 SIMPAN KE DATABASE
        $booking->update([
            'midtrans_order_id' => $orderId,
            'snap_token'        => $snapToken,
        ]);

        return view('user.bookings.pay', [
            'booking'   => $booking,
            'snapToken' => $snapToken,
        ]);
    }
}
