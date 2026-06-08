<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    protected $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findByBookingId(int $bookingId)
    {
        return $this->model->where('booking_id', $bookingId)->first();
    }

    public function findByTransactionId(string $transactionId)
    {
        return $this->model->where('transaction_id', $transactionId)->first();
    }

    public function update(int $id, array $data)
    {
        $payment = $this->model->find($id);
        
        if ($payment) {
            $payment->update($data);
            return $payment;
        }

        return null;
    }
}