<?php

namespace App\Repositories\Contracts;

use App\Models\SellerWallet;

interface WalletRepositoryInterface
{
    public function getWalletBySellerId(int $sellerId): SellerWallet;
    public function updateBalances(int $sellerId, float $pendingDiff, float $availableDiff, float $incomeDiff = 0): SellerWallet;
    public function createTransaction(array $data);
    public function getTransactionsPaginated(int $sellerId, int $perPage = 10);
    public function createWithdrawal(array $data);
    public function getWithdrawalsPaginated(int $sellerId, int $perPage = 10);
}