<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            Log::warning('Midtrans signature invalid', $request->all());
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        // ⬇️ PAKAI order_id
        $booking = Booking::where('order_id', $orderId)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'approved'
            ]);
        }

        if (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
            $booking->update([
                'payment_status' => 'failed',
                'status' => 'rejected'
            ]);
        }

        return response()->json(['message' => 'OK']);
    }
}
