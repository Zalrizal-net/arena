<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Services\SellerTransactionService;
use Illuminate\Support\Facades\Auth;

class IncomeDashboard extends Component
{
    public function render(SellerTransactionService $service)
    {
        $stats = $service->getDashboardStats(Auth::id());

        return view('livewire.seller.income-dashboard', compact('stats'))
            ->layout('layouts.app');
    }
}