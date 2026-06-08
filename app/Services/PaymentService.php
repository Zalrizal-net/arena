<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $paymentRepository;
    protected $bookingRepository;
    protected $MidtransService;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        BookingRepositoryInterface $bookingRepository,
        MidtransService $midtransService
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->bookingRepository = $bookingRepository;
        $this->MidtransService = $midtransService;
    }

    public function createPaymentForBooking(Booking $booking)
    {
        $existingPayment = $this->paymentRepository->findByBookingId($booking->id);
        
        if ($existingPayment && $existingPayment->snap_token) {
            return $existingPayment;
        }

        $transactionDetails = [
            'order_id' => $booking->booking_code,
            'gross_amount' => (int) $booking->total_price,
        ];

        $customerDetails = [
            'first_name' => $booking->user->name,
            'email' => $booking->user->email,
        ];

        $snapToken = $this->MidtransService->getSnapToken($transactionDetails, $customerDetails);

        $paymentData = [
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'gross_amount' => $booking->total_price,
            'snap_token' => $snapToken,
            'transaction_status' => 'pending',
        ];

        return $this->paymentRepository->create($paymentData);
    }

    public function handleMidtransCallback(array $notification)
    {
        $transactionStatus = $notification['transaction_status'];
        $orderId = $notification['order_id'];
        $fraudStatus = $notification['fraud_status'] ?? null;
        $transactionId = $notification['transaction_id'];
        $paymentType = $notification['payment_type'] ?? null;

        Log::info('Midtrans Notification Processing', $notification);

        $booking = Booking::where('booking_code', $orderId)->first();
        
        if (!$booking) {
            Log::error('Booking not found for callback order_id: ' . $orderId);
            return;
        }

        $payment = $this->paymentRepository->findByBookingId($booking->id);

        if (!$payment) {
            Log::error('Payment record not found for booking_id: ' . $booking->id);
            return;
        }

        $paymentStatus = 'pending';
        $bookingStatus = 'pending';
        $paymentStatusDb = 'unpaid';

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            if ($fraudStatus === 'challenge') {
                $paymentStatus = 'pending';
                $bookingStatus = 'pending';
            } else {
                $paymentStatus = 'paid';
                $bookingStatus = 'confirmed';
                $paymentStatusDb = 'paid';
            }
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire') {
            $paymentStatus = $transactionStatus === 'expire' ? 'expired' : 'failed';
            $bookingStatus = 'cancelled';
            $paymentStatusDb = 'unpaid';
        }

        $this->paymentRepository->update($payment->id, [
            'transaction_status' => $paymentStatus,
            'transaction_id' => $transactionId,
            'payment_type' => $paymentType,
            'fraud_status' => $fraudStatus,
            'paid_at' => $paymentStatus === 'paid' ? now() : null,
        ]);

        $this->bookingRepository->update($booking->id, [
            'payment_status' => $paymentStatusDb,
            'status' => $bookingStatus,
        ]);

        // JIKA PEMBAYARAN BERHASIL (PAID)
        if ($paymentStatus === 'paid') {
            
            // 1. Tahan Uang di Rekber (Escrow)
            try {
                // Memanggil WalletEscrowService tanpa harus mengubah __construct
                $walletService = app(\App\Services\WalletEscrowService::class);
                $walletService->holdPayment($booking);
                
                Log::info('Escrow hold successful for booking: ' . $booking->id);
            } catch (\Exception $e) {
                Log::error('Escrow hold failed for booking: ' . $booking->id . '. Error: ' . $e->getMessage());
            }

            // 2. Kirim Notifikasi
            $buyer = $booking->user;
            if ($buyer) {
                $buyer->notify(new \App\Notifications\PaymentSuccessNotification($booking, 'buyer'));
            }

            $seller = $booking->facility->seller;
            if ($seller) {
                $seller->notify(new \App\Notifications\PaymentSuccessNotification($booking, 'seller'));
            }
        }
    }
}