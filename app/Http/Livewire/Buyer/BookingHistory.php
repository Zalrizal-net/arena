<?php

namespace App\Http\Livewire\Buyer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class BookingHistory extends Component
{
    use WithPagination;

    // Menggunakan tema Tailwind untuk pagination Livewire
    protected $paginationTheme = 'tailwind';

    public function render(BookingRepositoryInterface $bookingRepository)
    {
        // Mengambil data pesanan dengan paginasi menggunakan Repository
        $bookings = $bookingRepository->getUserBookings(Auth::id(), 10);

        return view('livewire.buyer.booking-history', [
            'bookings' => $bookings
        ])->layout('layouts.app');
    }
}