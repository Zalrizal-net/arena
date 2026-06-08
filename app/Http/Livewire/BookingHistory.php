<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;

class BookingHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $bookingService = app(BookingService::class);
        $bookings = $bookingService->getUserBookings(Auth::id(), 5);

        return view('livewire.booking-history', [
            'bookings' => $bookings
        ])->layout('layouts.guest');
    }
}