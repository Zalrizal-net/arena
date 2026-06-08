<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Facility;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\ScheduleRepositoryInterface;
use App\Repositories\Contracts\FacilityRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BookingService
{
    protected BookingRepositoryInterface $bookingRepository;
    protected ScheduleRepositoryInterface $scheduleRepository;
    protected FacilityRepositoryInterface $facilityRepository;
    protected FacilityService $facilityService;
    protected ScheduleService $scheduleService;

    public function __construct(
        BookingRepositoryInterface $bookingRepository,
        ScheduleRepositoryInterface $scheduleRepository,
        FacilityRepositoryInterface $facilityRepository,
        FacilityService $facilityService,
        ScheduleService $scheduleService
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->facilityRepository = $facilityRepository;
        $this->facilityService = $facilityService;
        $this->scheduleService = $scheduleService;
    }

    public function createBooking(array $data, $userId)
    {
        $facility = Facility::findOrFail($data['facility_id']);
        
        $startTime = Carbon::parse($data['start_time']);
        $duration = isset($data['duration']) ? (int) $data['duration'] : 1;
        $endTime = $startTime->copy()->addHours($duration);

        $formattedStartTime = $startTime->format('H:i:s');
        $formattedEndTime = $endTime->format('H:i:s');

        $overlappingBookings = $this->bookingRepository->checkOverlap(
            $facility->id, 
            $data['booking_date'], 
            $formattedStartTime, 
            $formattedEndTime
        );

        if ($overlappingBookings > 0) {
            throw ValidationException::withMessages([
                'start_time' => 'Maaf, fasilitas sudah dipesan pada rentang waktu tersebut. Silakan pilih jam atau durasi lain.'
            ]);
        }

        $totalPrice = $facility->price_per_hour * $duration;

        $bookingData = [
            'booking_code' => 'ARN-' . date('ymd') . '-' . strtoupper(Str::random(4)),
            'user_id' => $userId,
            'facility_id' => $facility->id,
            'booking_date' => $data['booking_date'],
            'start_time' => $formattedStartTime,
            'end_time' => $formattedEndTime,
            'duration' => $duration, // <-- Nilai durasi sekarang berhasil disisipkan
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'notes' => $data['notes'] ?? null,
        ];

        return $this->bookingRepository->create($bookingData);
    }

    public function getBookingDetail(int $id, int $userId): Booking
    {
        $booking = $this->bookingRepository->findById($id);

        if (!$booking) {
            throw new ModelNotFoundException('Data pemesanan tidak ditemukan.');
        }

        if ($booking->user_id !== $userId) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Anda tidak memiliki akses ke pesanan ini.');
        }

        return $booking;
    }

    public function getUserBookings(int $userId, int $perPage = 10)
    {
        return $this->bookingRepository->getUserBookings($userId, $perPage);
    }

    protected function generateBookingCode(): string
    {
        $prefix = 'ARN';
        $date = Carbon::now()->format('ymd');
        $random = strtoupper(Str::random(4));
        
        // Contoh Output: ARN-260526-ABCD
        return $prefix . '-' . $date . '-' . $random;
    }

    public function cancelBooking($bookingId, $userId)
    {
        $booking = $this->bookingRepository->findByIdAndUser($bookingId, $userId);

        if ($booking->status === 'cancelled' || $booking->status === 'completed') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => 'Pesanan ini sudah tidak dapat dibatalkan.'
            ]);
        }

        // Gabungkan tanggal dan jam mulai menjadi instance Carbon
        $bookingDateTime = \Carbon\Carbon::parse($booking->booking_date->format('Y-m-d') . ' ' . $booking->start_time);
        
        // Cek jika waktu saat ini ditambah 2 jam melebihi atau sama dengan jadwal main
        if (now()->addHours(2)->greaterThanOrEqualTo($bookingDateTime)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => 'Pembatalan hanya dapat dilakukan maksimal 2 jam sebelum jadwal dimulai.'
            ]);
        }

        // Tentukan status pembayaran (jika sudah dibayar, ubah jadi refund_pending)
        $paymentStatus = $booking->payment_status === 'paid' ? 'refund_pending' : 'unpaid';

        $this->bookingRepository->update($booking->id, [
            'status' => 'cancelled',
            'payment_status' => $paymentStatus
        ]);
    }

    public function markAsOnGoing(int $bookingId, int $sellerId)
    {
        $booking = Booking::with('facility')->findOrFail($bookingId);

        if ($booking->facility->seller_id !== $sellerId) {
            throw new Exception("Anda tidak memiliki otoritas untuk memproses pesanan ini.");
        }

        if ($booking->status !== 'confirmed') {
            throw new Exception("Hanya pesanan berstatus Confirmed yang dapat dimulai.");
        }

        $booking->update([
            'status' => 'on_going',
            'updated_at' => now(),
        ]);

        return $booking;
    }

    public function markAsCompleted(int $bookingId, int $sellerId)
    {
        $booking = Booking::with('facility')->findOrFail($bookingId);

        if ($booking->facility->seller_id !== $sellerId) {
            throw new Exception("Anda tidak memiliki otoritas untuk memproses pesanan ini.");
        }

        if ($booking->status !== 'on_going' && $booking->status !== 'confirmed') {
            throw new Exception("Hanya pesanan yang sedang berjalan yang dapat diselesaikan.");
        }

        $booking->update([
            'status' => 'completed',
            'updated_at' => now(),
        ]);

        return $booking;
    }

}