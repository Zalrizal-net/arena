<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Contracts\SellerTransactionRepositoryInterface;

class SellerTransactionRepository implements SellerTransactionRepositoryInterface
{
    public function getBookingsPaginated(int $sellerId, array $filters = [], int $perPage = 10)
    {
        $query = Booking::with(['facility', 'user'])
            ->whereHas('facility', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            });

        if (!empty($filters['search'])) {
            $query->where('booking_code', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function findBookingById(int $sellerId, int $bookingId)
    {
        return Booking::with(['facility', 'user', 'payment'])
            ->whereHas('facility', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })
            ->findOrFail($bookingId);
    }

    public function updateBookingStatus(int $bookingId, string $status)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->update(['status' => $status]);
        
        return $booking;
    }

    public function getIncomeStats(int $sellerId)
    {
        $baseQuery = Booking::whereHas('facility', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        });

        $totalTransactions = (clone $baseQuery)->where('payment_status', 'paid')->count();
        $totalBookings = (clone $baseQuery)->count();
        
        $pendingBalance = (clone $baseQuery)
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'completed')
            ->sum('total_price');

        $availableBalance = (clone $baseQuery)
            ->where('payment_status', 'paid')
            ->where('status', 'completed')
            ->sum('total_price');

        $totalIncome = $pendingBalance + $availableBalance;

        return [
            'total_transactions' => $totalTransactions,
            'total_bookings' => $totalBookings,
            'total_income' => $totalIncome,
            'pending_balance' => $pendingBalance,
            'available_balance' => $availableBalance,
        ];
    }
}