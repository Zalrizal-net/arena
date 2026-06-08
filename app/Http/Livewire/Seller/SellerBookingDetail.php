<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Services\SellerTransactionService;
use Illuminate\Support\Facades\Auth;
use Exception;

class SellerBookingDetail extends Component
{
    public $bookingId;
    public $booking;

    public function mount(int $id, SellerTransactionService $service)
    {
        $this->bookingId = $id;
        $this->loadBooking($service);
    }

    public function loadBooking(SellerTransactionService $service)
    {
        $this->booking = $service->getBookingDetail(Auth::id(), $this->bookingId);
    }

    public function updateStatus(string $status, SellerTransactionService $service, \App\Services\WalletEscrowService $walletService)
    {
        try {
            $service->updateBookingStatus(Auth::id(), $this->bookingId, $status);
            
            // JIKA STATUS DIUBAH JADI COMPLETED, RILIS DANANYA!
            if ($status === 'completed') {
                $booking = \App\Models\Booking::with('facility')->find($this->bookingId);
                $walletService->releasePayment($booking);
            }

            $this->loadBooking($service);
            session()->flash('success', 'Status booking berhasil diperbarui.');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.seller.booking-detail')->layout('layouts.app');
    }
}