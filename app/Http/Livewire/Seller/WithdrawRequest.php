<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Services\WalletEscrowService;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class WithdrawRequest extends Component
{
    public $amount;
    public $bank_name;
    public $account_name;
    public $account_number;
    public $notes;

    protected $rules = [
        'amount' => 'required|numeric|min:50000',
        'bank_name' => 'required|string|max:100',
        'account_name' => 'required|string|max:150',
        'account_number' => 'required|string|max:50',
        'notes' => 'nullable|string|max:255',
    ];

    public function submit(WalletEscrowService $escrowService)
    {
        $this->validate();

        try {
            $escrowService->requestWithdrawal(Auth::id(), [
                'amount' => $this->amount,
                'bank_name' => $this->bank_name,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
                'notes' => $this->notes,
            ]);

            session()->flash('success', 'Pengajuan tarik dana berhasil dibuat! Tim kami akan segera memprosesnya.');
            return redirect()->route('seller.wallet.index');
            
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(WalletRepositoryInterface $walletRepo)
    {
        $wallet = $walletRepo->getWalletBySellerId(Auth::id());
        
        return view('livewire.seller.withdraw-request', [
            'wallet' => $wallet
        ])->layout('layouts.app');
    }
}