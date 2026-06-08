<?php

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ScheduleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class ScheduleService
{
    protected ScheduleRepositoryInterface $scheduleRepository;
    protected FacilityService $facilityService;

    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository,
        FacilityService $facilityService
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->facilityService = $facilityService;
    }

    public function getFacilitySchedules(int $facilityId, int $sellerId)
    {
        $this->facilityService->getFacilityDetail($facilityId, $sellerId);
        return $this->scheduleRepository->getFacilitySchedules($facilityId);
    }

    public function getActiveSchedulesForPublic(int $facilityId)
    {
        return $this->scheduleRepository->getActiveSchedules($facilityId);
    }

    public function getScheduleDetail(int $id, int $sellerId): Schedule
    {
        $schedule = $this->scheduleRepository->findById($id);

        if (!$schedule) {
            throw new ModelNotFoundException('Jadwal tidak ditemukan.');
        }

        if ($schedule->facility->seller_id !== $sellerId) {
            throw new AuthorizationException('Anda tidak memiliki akses untuk memodifikasi jadwal ini.');
        }

        return $schedule;
    }

    public function createSchedule(array $data, int $sellerId): Schedule
    {
        $this->facilityService->getFacilityDetail($data['facility_id'], $sellerId);
        
        $this->validateScheduleConflict($data['facility_id'], $data['day_of_week']);
        $this->validateTimeAndDuration($data['open_time'], $data['close_time'], $data['slot_duration']);

        return $this->scheduleRepository->create($data);
    }

    public function updateSchedule(int $id, array $data, int $sellerId): Schedule
    {
        $schedule = $this->getScheduleDetail($id, $sellerId);
        
        $this->validateScheduleConflict($schedule->facility_id, $data['day_of_week'], $id);
        $this->validateTimeAndDuration($data['open_time'], $data['close_time'], $data['slot_duration']);

        return $this->scheduleRepository->update($schedule, $data);
    }

    public function deleteSchedule(int $id, int $sellerId): bool
    {
        $schedule = $this->getScheduleDetail($id, $sellerId);
        return $this->scheduleRepository->delete($schedule);
    }

    public function validateScheduleConflict(int $facilityId, int $dayOfWeek, ?int $excludeId = null): void
    {
        $isDuplicate = $this->scheduleRepository->checkDuplicateDay($facilityId, $dayOfWeek, $excludeId);
        
        if ($isDuplicate) {
            throw ValidationException::withMessages([
                'day_of_week' => 'Jadwal untuk hari ini sudah ada pada fasilitas tersebut.'
            ]);
        }
    }

    protected function validateTimeAndDuration(string $openTime, string $closeTime, int $duration): void
    {
        $open = Carbon::createFromFormat('H:i', substr($openTime, 0, 5));
        $close = Carbon::createFromFormat('H:i', substr($closeTime, 0, 5));

        if ($close->lte($open)) {
            throw ValidationException::withMessages([
                'close_time' => 'Jam tutup harus lebih besar dari jam buka.'
            ]);
        }

        if ($duration < 30) {
            throw ValidationException::withMessages([
                'slot_duration' => 'Durasi slot minimal adalah 30 menit.'
            ]);
        }
    }

    public function generateSlots(string $openTime, string $closeTime, int $duration): array
    {
        $slots = [];
        $startTime = Carbon::createFromFormat('H:i:s', strlen($openTime) === 5 ? $openTime . ':00' : $openTime);
        $endTime = Carbon::createFromFormat('H:i:s', strlen($closeTime) === 5 ? $closeTime . ':00' : $closeTime);

        while ($startTime->copy()->addMinutes($duration)->lte($endTime)) {
            $slots[] = $startTime->format('H:i');
            $startTime->addMinutes($duration);
        }

        return $slots;
    }


    // Pastikan Anda sudah menambahkan ini di bagian atas file:
    // use Illuminate\Support\Facades\DB;

    public function getAvailableSlots(int $facilityId, string $date): array
    {
        $carbonDate = Carbon::parse($date)->timezone('Asia/Jakarta');
        
        // Tolak jika tanggal yang dipilih adalah masa lalu (kemarin dsb)
        if ($carbonDate->isPast() && !$carbonDate->isToday()) {
            return [];
        }

        // Carbon dayOfWeekIso menghasilkan 1 (Senin) sampai 7 (Minggu)
        $dayOfWeek = $carbonDate->dayOfWeekIso;

        // Ambil jadwal aktif
        $schedule = $this->scheduleRepository->getByFacilityAndDay($facilityId, $dayOfWeek);

        if (!$schedule) {
            return []; // Fasilitas tutup pada hari ini
        }

        // Generate semua kemungkinan slot dari jam buka sampai jam tutup
        $allSlots = $this->generateSlots($schedule->open_time, $schedule->close_time, $schedule->slot_duration);
        $availableSlots = [];
        $now = Carbon::now('Asia/Jakarta');
        $isToday = $carbonDate->isToday();

        // Ambil slot yang sudah dibooking pada tanggal tersebut
        // Asumsi status: pending (menunggu bayar), paid (sudah bayar), confirmed (diterima)
        $bookedSlots = DB::table('bookings')
            ->where('facility_id', $facilityId)
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['pending', 'paid', 'confirmed'])
            ->pluck('start_time')
            ->map(function($time) {
                return substr($time, 0, 5); // Normalisasi format menjadi H:i
            })
            ->toArray();

        foreach ($allSlots as $slot) {
            // Evaluasi 1: Cek apakah slot sudah lewat waktunya (khusus hari ini)
            if ($isToday) {
                $slotTime = Carbon::createFromFormat('H:i', $slot, 'Asia/Jakarta');
                if ($now->greaterThanOrEqualTo($slotTime)) {
                    $availableSlots[] = [
                        'time' => $slot,
                        'is_available' => false,
                        'reason' => 'passed' // Waktu sudah terlewat
                    ];
                    continue;
                }
            }

            // Evaluasi 2: Cek apakah slot sudah dibooking orang lain
            if (in_array($slot, $bookedSlots)) {
                $availableSlots[] = [
                    'time' => $slot,
                    'is_available' => false,
                    'reason' => 'booked' // Sudah dipesan
                ];
            } else {
                // Lolos semua evaluasi, slot siap dipesan
                $availableSlots[] = [
                    'time' => $slot,
                    'is_available' => true,
                    'reason' => null
                ];
            }
        }

        return $availableSlots;
    }
}