<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\WalletTransaction;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class WalletEscrowService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {}

    /**
     * TAHAP 8: LOGIC ESCROW
     * Dipanggil saat Webhook Midtrans menyatakan Payment Success.
     * Uang ditahan (masuk ke pending_balance).
     */
    public function holdPayment(Booking $booking)
    {
        DB::beginTransaction();
        try {
            $sellerId = $booking->facility->seller_id;
            $amount = $booking->total_price;

            // 1. Tambah ke pending_balance (+ amount), available tetap (+ 0)
            $this->walletRepository->updateBalances($sellerId, $amount, 0);

            // 2. Catat di riwayat mutasi (Ledger)
            $this->walletRepository->createTransaction([
                'seller_id' => $sellerId,
                'booking_id' => $booking->id,
                'amount' => $amount,
                'type' => 'income',
                'status' => 'pending', // Status transaksi dompetnya masih pending
                'description' => "Pembayaran ditahan untuk Booking #" . $booking->booking_code,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * TAHAP 9: LOGIC RELEASE BALANCE
     * Dipanggil saat Seller/Sistem mengubah status Booking menjadi 'completed'.
     * Uang cair (pindah dari pending ke available).
     */
    public function releasePayment(Booking $booking)
    {
        DB::beginTransaction();
        try {
            $sellerId = $booking->facility->seller_id;
            $amount = $booking->total_price;

            // 1. Kurangi pending_balance (-amount), tambah available (+amount), tambah total income (+amount)
            $this->walletRepository->updateBalances($sellerId, -$amount, $amount, $amount);

            // 2. Update status transaksi dompet yang sebelumnya 'pending' menjadi 'completed'
            WalletTransaction::where('booking_id', $booking->id)
                ->where('type', 'income')
                ->update(['status' => 'completed', 'description' => "Dana cair untuk Booking #" . $booking->booking_code]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * TAHAP 10: LOGIC WITHDRAW
     * Dipanggil saat Seller mengajukan penarikan dana.
     */
    public function requestWithdrawal(int $sellerId, array $data)
    {
        DB::beginTransaction();
        try {
            $wallet = $this->walletRepository->getWalletBySellerId($sellerId);
            $amount = floatval($data['amount']);

            // Validasi 1: Minimal penarikan (misal Rp 50.000)
            if ($amount < 50000) {
                throw new Exception('Minimal penarikan adalah Rp 50.000.');
            }

            // Validasi 2: Saldo cukup?
            if ($wallet->available_balance < $amount) {
                throw new Exception('Saldo tersedia tidak mencukupi untuk penarikan ini.');
            }

            // 1. Potong saldo available langsung agar tidak bisa ditarik dobel (-amount)
            $this->walletRepository->updateBalances($sellerId, 0, -$amount);

            // 2. Buat data pengajuan Withdraw
            $withdrawal = $this->walletRepository->createWithdrawal([
                'seller_id' => $sellerId,
                'amount' => $amount,
                'bank_name' => $data['bank_name'],
                'account_name' => $data['account_name'],
                'account_number' => $data['account_number'],
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
            ]);

            // 3. Catat di mutasi dompet sebagai uang keluar
            $this->walletRepository->createTransaction([
                'seller_id' => $sellerId,
                'booking_id' => null, // Tidak ada booking ID karena ini penarikan
                'amount' => -$amount, // Minus karena uang keluar
                'type' => 'withdrawal',
                'status' => 'pending',
                'description' => "Pengajuan penarikan dana ke " . $data['bank_name'] . " - " . $data['account_number'],
            ]);

            DB::commit();
            return $withdrawal;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}