<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;

class SellerDashboard extends Component
{
    public function render()
    {
        // Ubah target layout ke 'layouts.app' agar menggunakan kerangka utama yang sudah kita rapikan
        return view('livewire.seller.seller-dashboard')
            ->layout('layouts.app');
    }
}