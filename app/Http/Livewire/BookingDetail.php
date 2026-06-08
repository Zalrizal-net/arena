<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class BookingDetail extends Component
{
    public $bookingId;
    public $booking;

    public function mount($id)
    {
        $this->bookingId = $id;
        $this->loadBooking();
    }

    public function loadBooking()
    {
        try {
            $bookingService = app(BookingService::class);
            $this->booking = $bookingService->getBookingDetail($this->bookingId, Auth::id());
        } catch (ModelNotFoundException | AuthorizationException $e) {
            session()->flash('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->route('booking.history');
        }
    }

    public function cancelBooking()
    {
        try {
            $bookingService = app(BookingService::class);
            $bookingService->cancelBooking($this->bookingId, Auth::id());
            
            session()->flash('success', 'Pesanan berhasil dibatalkan.');
            $this->loadBooking(); // Muat ulang data untuk update status UI
        } catch (ValidationException $e) {
            session()->flash('error', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.booking-detail')->layout('layouts.guest');
    }
}