<?php

namespace App\Services;

use App\Repositories\Contracts\SellerTransactionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SellerTransactionService
{
    public function __construct(
        private SellerTransactionRepositoryInterface $transactionRepository
    ) {}

    public function listSellerBookings(int $sellerId, array $filters = [], int $perPage = 10)
    {
        return $this->transactionRepository->getBookingsPaginated($sellerId, $filters, $perPage);
    }

    public function getBookingDetail(int $sellerId, int $bookingId)
    {
        return $this->transactionRepository->findBookingById($sellerId, $bookingId);
    }

    public function updateBookingStatus(int $sellerId, int $bookingId, string $newStatus)
    {
        DB::beginTransaction();
        try {
            // Panggil detail untuk memastikan ownership (akan throw 404 jika bukan miliknya)
            $booking = $this->transactionRepository->findBookingById($sellerId, $bookingId);
            
            // Aturan Bisnis Opsional: Pastikan tidak bisa ubah status kalau sudah dibatalkan
            if ($booking->status === 'cancelled') {
                throw new Exception('Tidak dapat mengubah status booking yang sudah dibatalkan.');
            }

            $updatedBooking = $this->transactionRepository->updateBookingStatus($booking->id, $newStatus);
            
            DB::commit();
            return $updatedBooking;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getDashboardStats(int $sellerId)
    {
        return $this->transactionRepository->getIncomeStats($sellerId);
    }
}