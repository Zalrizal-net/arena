<?php

namespace App\Repositories\Contracts;

interface SellerTransactionRepositoryInterface
{
    public function getBookingsPaginated(int $sellerId, array $filters = [], int $perPage = 10);
    public function findBookingById(int $sellerId, int $bookingId);
    public function updateBookingStatus(int $bookingId, string $status);
    public function getIncomeStats(int $sellerId);
}