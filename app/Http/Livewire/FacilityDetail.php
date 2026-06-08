<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\FacilityService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class FacilityDetail extends Component
{
    public $facility;
    public $mainImage;
    
    public $selectedDate;
    public $availableSlots = [];
    public $selectedSlot = null;
    
    public $duration = 1; 
    public $availableDurations = []; // Array untuk menyimpan opsi durasi yang aman
    

    public function mount($slug, FacilityService $facilityService)
    {
        try {
            $this->facility = $facilityService->getFacilityBySlug($slug);
            $this->mainImage = $this->facility->thumbnail;
            
            $this->selectedDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $this->loadSlots();

        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function updatedSelectedDate()
    {
        $this->selectedSlot = null;
        $this->duration = 1;
        $this->availableDurations = [];
        $this->loadSlots();
    }

    public function loadSlots()
    {
        $scheduleService = app(ScheduleService::class);
        $this->availableSlots = $scheduleService->getAvailableSlots(
            $this->facility->id, 
            $this->selectedDate
        );
    }

    public function selectSlot($time)
    {
        $this->selectedSlot = $time;
        $this->duration = 1; // Reset durasi ke 1 setiap kali memilih jam baru
        
        // Logika cerdas: Hitung ketersediaan slot secara berurutan
        $this->availableDurations = [];
        $startIndex = -1;

        foreach ($this->availableSlots as $index => $slot) {
            if ($slot['time'] === $this->selectedSlot) {
                $startIndex = $index;
                break;
            }
        }

        if ($startIndex !== -1) {
            $consecutive = 0;
            for ($i = $startIndex; $i < count($this->availableSlots); $i++) {
                if ($this->availableSlots[$i]['is_available']) {
                    $consecutive++;
                    $this->availableDurations[] = $consecutive;
                    if ($consecutive >= 5) break; // Batas maksimal main 5 jam
                } else {
                    break; // STOP! Ada jadwal orang lain yang menghalangi
                }
            }
        }
    }

    public function bookFacility()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk melanjutkan pemesanan.');
            
            // JURUS BARU: Kirim URL tujuan sebagai parameter '?next=' di link
            return redirect()->route('login', ['next' => route('facilities.show', $this->facility->slug)]);
        }

        if (Auth::user()->role !== 'buyer') {
            session()->flash('error', 'Hanya akun pembeli (buyer) yang dapat melakukan pemesanan.');
            return;
        }

        if (!$this->selectedDate || !$this->selectedSlot) {
            session()->flash('error', 'Silakan pilih tanggal dan jam slot terlebih dahulu.');
            return;
        }

        session()->put('booking_data', [
            'facility_id' => $this->facility->id,
            'slug' => $this->facility->slug,
            'booking_date' => $this->selectedDate,
            'start_time' => $this->selectedSlot,
            'duration' => (int) $this->duration,
            'price' => $this->facility->price_per_hour * $this->duration
        ]);

        return redirect()->route('booking.checkout');
    }

    public function setMainImage($imagePath)
    {
        $this->mainImage = $imagePath;
    }

    public function render()
    {
        return view('livewire.facility-detail')->layout('layouts.guest');
    }
}