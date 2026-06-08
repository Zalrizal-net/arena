<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function findById(int $id): ?Booking
    {
        return Booking::with(['facility', 'facility.seller'])->find($id);
    }

    public function findByBookingCode(string $bookingCode): ?Booking
    {
        return Booking::with(['facility'])->where('booking_code', $bookingCode)->first();
    }

    public function getUserBookings(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Booking::with(['facility'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findByIdAndUser($id, $userId)
    {
        return Booking::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function getByUserId($userId)
    {
        return Booking::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function update($id, array $data)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($data);
        
        return $booking;
    }

    public function checkOverlap($facilityId, $date, $startTime, $endTime): int
    {
        return Booking::where('facility_id', $facilityId)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->count();
    }
}