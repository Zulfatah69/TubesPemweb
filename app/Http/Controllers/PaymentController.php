<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handle(Request $request)
    {
        // log masuk webhook
        Log::info('MIDTRANS WEBHOOK MASUK', $request->all());

        $serverKey = config('services.midtrans.server_key');

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

        // ⚠️ PENTING: pakai kolom order_id
        $booking = Booking::where('order_id', $orderId)->first();

        if (!$booking) {
            Log::error('Booking not found for order_id: ' . $orderId);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $booking->update([
                'payment_status' => 'paid',
            ]);

            Log::info('Booking marked as PAID: ' . $booking->id);
        }

        if (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
            $booking->update([
                'payment_status' => 'failed',
            ]);

            Log::info('Booking marked as FAILED: ' . $booking->id);
        }

        return response()->json(['message' => 'OK']);
    }
}
