<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'transaction_id' => $this->transaction_id,
            'snap_token' => $this->snap_token,
            'payment_type' => $this->payment_type,
            'gross_amount' => (float) $this->gross_amount,
            'transaction_status' => $this->transaction_status,
            'fraud_status' => $this->fraud_status,
            'paid_at' => $this->paid_at ? $this->paid_at->toIso8601String() : null,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}