<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\SellerTransactionService;
use Illuminate\Support\Facades\Auth;

class BookingList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    
    // Reset pagination ketika melakukan pencarian
    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }

    public function render(SellerTransactionService $service)
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->status,
        ];

        $bookings = $service->listSellerBookings(Auth::id(), $filters);

        return view('livewire.seller.booking-list', compact('bookings'))
            ->layout('layouts.app'); // Gunakan layout universal yang sudah dirapikan sebelumnya
    }
}