<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\ScheduleService;

class ScheduleResource extends JsonResource
{
    public function toArray($request): array
    {
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        $scheduleService = app(ScheduleService::class);
        
        // Membersihkan format jam (contoh: '08:00:00' menjadi '08:00')
        $openTime = substr($this->open_time, 0, 5);
        $closeTime = substr($this->close_time, 0, 5);

        return [
            'id' => $this->id,
            'facility_id' => $this->facility_id,
            'day_of_week' => $this->day_of_week,
            'day_name' => $days[$this->day_of_week] ?? 'Unknown',
            'open_time' => $openTime,
            'close_time' => $closeTime,
            'slot_duration' => $this->slot_duration,
            'is_active' => $this->is_active,
            'generated_slots' => $scheduleService->generateSlots($openTime, $closeTime, $this->slot_duration),
            'total_slots' => count($scheduleService->generateSlots($openTime, $closeTime, $this->slot_duration)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}