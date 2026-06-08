<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SellerTransactionService;
use Illuminate\Http\Request;

class SellerTransactionController extends Controller
{
    public function __construct(
        private SellerTransactionService $transactionService
    ) {}

    public function getDashboard(Request $request)
    {
        $stats = $this->transactionService->getDashboardStats($request->user()->id);
        return response()->json(['data' => $stats]);
    }

    public function indexBookings(Request $request)
    {
        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'payment_status' => $request->query('payment_status'),
        ];
        
        $bookings = $this->transactionService->listSellerBookings($request->user()->id, $filters);
        
        return response()->json($bookings);
    }

    public function showBooking(Request $request, $id)
    {
        $booking = $this->transactionService->getBookingDetail($request->user()->id, $id);
        return response()->json(['data' => $booking]);
    }
}