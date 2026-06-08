<?php

namespace App\Repositories\Contracts;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingRepositoryInterface
{
    public function create(array $data): Booking;
    
    public function findById(int $id): ?Booking;
    
    public function findByBookingCode(string $bookingCode): ?Booking;
    
    public function getUserBookings(int $userId, int $perPage = 10): LengthAwarePaginator;
    
    public function findByIdAndUser($id, $userId);
    
    public function getByUserId($userId);
    
    public function update($id, array $data);
    
    public function checkOverlap($facilityId, $date, $startTime, $endTime): int;
}