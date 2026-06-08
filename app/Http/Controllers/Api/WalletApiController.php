<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\WalletResource;

class WalletApiController extends Controller
{
    protected $walletRepo;

    public function __construct(WalletRepositoryInterface $walletRepo)
    {
        $this->walletRepo = $walletRepo;
    }

    public function index(Request $request)
    {
        $sellerId = $request->user()->id;

        $wallet = $this->walletRepo->getWalletBySellerId($sellerId);
        $transactions = $this->walletRepo->getTransactionsPaginated($sellerId, 10);
        $withdrawals = $this->walletRepo->getWithdrawalsPaginated($sellerId, 5);

        return response()->json([
            'status' => 'success',
            'message' => 'Data dompet berhasil diambil',
            'data' => [
                'wallet' => new WalletResource($wallet),
                'recent_transactions' => $transactions->items(),
                'recent_withdrawals' => $withdrawals->items(),
            ]
        ], 200);
    }

    public function requestWithdraw(WithdrawRequest $request)
    {
        $sellerId = $request->user()->id;
        $amount = $request->amount;

        $wallet = $this->walletRepo->getWalletBySellerId($sellerId);

        if ($wallet->available_balance < $amount) {
            return response()->json([
                'status' => 'error',
                'message' => 'Saldo yang bisa ditarik tidak mencukupi untuk nominal penarikan ini.',
                'data' => [
                    'available_balance' => (float) $wallet->available_balance,
                    'requested_amount' => (float) $amount
                ]
            ], 400);
        }

        DB::beginTransaction();
        try {
            $this->walletRepo->updateBalances($sellerId, 0, -$amount, 0);

            $withdrawal = $this->walletRepo->createWithdrawal([
                'seller_id' => $sellerId,
                'amount' => $amount,
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'status' => 'pending'
            ]);

            $transaction = $this->walletRepo->createTransaction([
                'seller_id' => $sellerId,
                'amount' => $amount,
                'type' => 'WITHDRAWAL',
                'status' => 'PENDING',
                'description' => 'Pengajuan penarikan dana ke ' . strtoupper($request->bank_name) . ' - ' . $request->account_number
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan penarikan dana berhasil dibuat dan sedang menunggu proses.',
                'data' => [
                    'withdrawal_id' => $withdrawal->id,
                    'transaction_id' => $transaction->id,
                    'remaining_balance' => (float) ($wallet->available_balance - $amount)
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem saat memproses penarikan dana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}