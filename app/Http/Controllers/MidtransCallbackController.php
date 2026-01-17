<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('MIDTRANS CALLBACK:', $request->all());

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        if (!$orderId) {
            return response()->json(['error' => 'No order_id'], 400);
        }

        $booking = Booking::find($orderId);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'approved',
            ]);
        }

        return response()->json(['success' => true]);
    }
}
