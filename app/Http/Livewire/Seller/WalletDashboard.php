<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class WalletDashboard extends Component
{
    use WithPagination;

    public function render(WalletRepositoryInterface $walletRepo)
    {
        $sellerId = Auth::id();
        
        // Ambil data saldo dompet
        $wallet = $walletRepo->getWalletBySellerId($sellerId);
        
        // Ambil riwayat mutasi (uang masuk, keluar, dll)
        $transactions = $walletRepo->getTransactionsPaginated($sellerId, 10);

        return view('livewire.seller.wallet-dashboard', [
            'wallet' => $wallet,
            'transactions' => $transactions,
        ])->layout('layouts.app');
    }
}