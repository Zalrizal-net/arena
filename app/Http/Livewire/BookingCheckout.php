<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Facility;
use App\Services\BookingService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class BookingCheckout extends Component
{
    public $bookingData;
    public $facility;
    public $notes;
    
    // 1. Tambahkan dua properti baru ini
    public $duration; 
    public $totalPrice;

    public function mount()
    {
        $this->bookingData = session('booking_data');

        if (!$this->bookingData) {
            return redirect()->route('facilities.index');
        }

        $this->facility = Facility::findOrFail($this->bookingData['facility_id']);
        
        // 2. Ambil durasi dari session (Default 1 jika tidak ada)
        $this->duration = $this->bookingData['duration'] ?? 1;
        
        // 3. Kalikan harga per jam dengan durasi untuk total tagihan
        $this->totalPrice = $this->facility->price_per_hour * $this->duration;
    }

    public function confirmBooking(BookingService $bookingService, PaymentService $paymentService)
    {
        $data = [
            'facility_id' => $this->facility->id,
            'booking_date' => $this->bookingData['booking_date'],
            'start_time' => $this->bookingData['start_time'],
            'duration' => $this->duration, 
            'notes' => $this->notes,
        ];

        $booking = $bookingService->createBooking($data, Auth::id());

        $payment = $paymentService->createPaymentForBooking($booking);

        $this->dispatchBrowserEvent('trigger-snap', [
            'snapToken' => $payment->snap_token
        ]);
    }

    public function render()
    {
        return view('livewire.booking-checkout')->layout('layouts.guest');
    }
}