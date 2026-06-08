<?php

namespace App\Repositories\Contracts;

interface PaymentRepositoryInterface
{
    public function create(array $data);
    
    public function findByBookingId(int $bookingId);
    
    public function findByTransactionId(string $transactionId);
    
    public function update(int $id, array $data);
}