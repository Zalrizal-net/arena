<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\FacilityService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;

class ScheduleList extends Component
{
    use WithPagination;

    public $facilityId;
    public $facilityName;

    public function mount($facilityId)
    {
        $this->facilityId = $facilityId;
        
        try {
            $facilityService = app(FacilityService::class);
            $facility = $facilityService->getFacilityDetail($this->facilityId, Auth::id());
            $this->facilityName = $facility->name;
        } catch (\Exception $e) {
            session()->flash('error', 'Fasilitas tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->route('seller.facilities.index');
        }
    }

    public function deleteSchedule(int $id)
    {
        $scheduleService = app(ScheduleService::class);

        try {
            $scheduleService->deleteSchedule($id, Auth::id());
            session()->flash('success', 'Jadwal operasional berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }

    public function toggleStatus(int $id)
    {
        $scheduleService = app(ScheduleService::class);

        try {
            $schedule = $scheduleService->getScheduleDetail($id, Auth::id());
            
            $data = [
                'day_of_week' => $schedule->day_of_week,
                'open_time' => $schedule->open_time,
                'close_time' => $schedule->close_time,
                'slot_duration' => $schedule->slot_duration,
                'is_active' => !$schedule->is_active,
            ];

            $scheduleService->updateSchedule($id, $data, Auth::id());
            session()->flash('success', 'Status jadwal berhasil diperbarui.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function getDayName(int $dayNumber): string
    {
        $days = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
            4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'
        ];
        return $days[$dayNumber] ?? 'Unknown';
    }

    public function render()
    {
        $scheduleService = app(ScheduleService::class);
        $schedules = $scheduleService->getFacilitySchedules($this->facilityId, Auth::id());

        return view('livewire.seller.schedule-list', [
            'schedules' => $schedules
        ])->layout('layouts.app');
    }
}