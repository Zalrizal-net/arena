<?php

namespace App\Repositories;

use App\Models\SellerWallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Repositories\Contracts\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    public function getWalletBySellerId(int $sellerId): SellerWallet
    {
        // Murni membaca dari tabel seller_wallets bawaan Escrow.
        // Sangat cepat dan tidak terpengaruh jika Abang hapus-hapus riwayat saat testing.
        return SellerWallet::firstOrCreate(
            ['seller_id' => $sellerId],
            [
                'pending_balance' => 0,
                'available_balance' => 0,
                'total_income' => 0,
            ]
        );
    }

    public function updateBalances(int $sellerId, float $pendingDiff, float $availableDiff, float $incomeDiff = 0): SellerWallet
    {
        $wallet = $this->getWalletBySellerId($sellerId);
        
        $wallet->pending_balance += $pendingDiff;
        $wallet->available_balance += $availableDiff;
        $wallet->total_income += $incomeDiff;
        $wallet->save();

        return $wallet;
    }

    public function createTransaction(array $data)
    {
        return WalletTransaction::create($data);
    }

    public function getTransactionsPaginated(int $sellerId, int $perPage = 10)
    {
        return WalletTransaction::where('seller_id', $sellerId)
            ->latest()
            ->paginate($perPage);
    }

    public function createWithdrawal(array $data)
    {
        return Withdrawal::create($data);
    }

    public function getWithdrawalsPaginated(int $sellerId, int $perPage = 10)
    {
        return Withdrawal::where('seller_id', $sellerId)
            ->latest()
            ->paginate($perPage);
    }
}