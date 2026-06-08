<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function handleCallback(Request $request)
    {
        $notification = $request->all();

        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $signatureKey = $notification['signature_key'] ?? '';
        $serverKey = config('midtrans.server_key');

        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($calculatedSignature !== $signatureKey) {
            Log::error('Invalid Midtrans Signature', ['notification' => $notification]);
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature'
            ], 403);
        }

        try {
            $this->paymentService->handleMidtransCallback($notification);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Callback processed successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Processing Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error'
            ], 500);
        }
    }
}