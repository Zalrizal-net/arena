<?php

namespace App\Http\Livewire\Buyer;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BuyerDashboard extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // Mengambil statistik pesanan pengguna
        $totalBookings = Booking::where('user_id', $userId)->count();
        $pendingPayments = Booking::where('user_id', $userId)->where('payment_status', 'unpaid')->count();
        $completedBookings = Booking::where('user_id', $userId)->where('status', 'completed')->count();

        // Mengambil 5 pesanan terbaru untuk ditampilkan di tabel/list
        $recentBookings = Booking::with('facility')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.buyer.buyer-dashboard', [
            'totalBookings' => $totalBookings,
            'pendingPayments' => $pendingPayments,
            'completedBookings' => $completedBookings,
            'recentBookings' => $recentBookings,
        ])->layout('layouts.app'); 
    }
}