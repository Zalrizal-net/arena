<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Services\FacilityService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ScheduleForm extends Component
{
    public $facilityId;
    public $facilityName;
    public $scheduleId = null;

    // Form Fields
    public $day_of_week = '';
    public $open_time = '08:00';
    public $close_time = '22:00';
    public $slot_duration = 60;
    public $is_active = true;

    protected $rules = [
        'day_of_week' => 'required|integer|between:1,7',
        'open_time' => 'required|date_format:H:i',
        'close_time' => 'required|date_format:H:i',
        'slot_duration' => 'required|integer|min:30',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'required' => 'Kolom ini wajib diisi.',
        'min' => 'Durasi minimal adalah 30 menit.',
        'date_format' => 'Format waktu tidak valid.',
    ];

    public function mount($facilityId, $scheduleId = null)
    {
        $this->facilityId = $facilityId;
        
        $facilityService = app(FacilityService::class);
        $scheduleService = app(ScheduleService::class);

        try {
            // Validasi kepemilikan fasilitas
            $facility = $facilityService->getFacilityDetail($this->facilityId, Auth::id());
            $this->facilityName = $facility->name;

            // Jika mode Edit, ambil data jadwal
            if ($scheduleId) {
                $this->scheduleId = $scheduleId;
                $schedule = $scheduleService->getScheduleDetail($this->scheduleId, Auth::id());
                
                $this->day_of_week = $schedule->day_of_week;
                // Potong detik (08:00:00 -> 08:00) agar cocok dengan input type="time" HTML
                $this->open_time = substr($schedule->open_time, 0, 5); 
                $this->close_time = substr($schedule->close_time, 0, 5);
                $this->slot_duration = $schedule->slot_duration;
                $this->is_active = $schedule->is_active;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->route('seller.schedules.index', $this->facilityId);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $scheduleService = app(ScheduleService::class);

        $data = [
            'facility_id' => $this->facilityId,
            'day_of_week' => $this->day_of_week,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'slot_duration' => $this->slot_duration,
            'is_active' => $this->is_active,
        ];

        try {
            if ($this->scheduleId) {
                $scheduleService->updateSchedule($this->scheduleId, $data, Auth::id());
                session()->flash('success', 'Jadwal operasional berhasil diperbarui!');
            } else {
                $scheduleService->createSchedule($data, Auth::id());
                session()->flash('success', 'Jadwal operasional baru berhasil ditambahkan!');
            }

            return redirect()->route('seller.schedules.index', $this->facilityId);

        } catch (ValidationException $e) {
            // Menangkap error khusus dari Service (seperti bentrok hari atau jam tutup < jam buka)
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $previewSlots = [];
        
        // Generate preview slot secara real-time jika input valid
        if ($this->open_time && $this->close_time && (int)$this->slot_duration >= 30) {
            if (strtotime($this->close_time) > strtotime($this->open_time)) {
                $scheduleService = app(ScheduleService::class);
                $previewSlots = $scheduleService->generateSlots($this->open_time, $this->close_time, (int)$this->slot_duration);
            }
        }

        return view('livewire.seller.schedule-form', [
            'previewSlots' => $previewSlots
        ])->layout('layouts.app');
    }
}