<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'booking_code' => $this->booking_code,
            'booking_date' => $this->booking_date->format('Y-m-d'),
            'start_time' => substr($this->start_time, 0, 5),
            'end_time' => substr($this->end_time, 0, 5),
            'duration' => $this->duration,
            'total_price' => (float) $this->total_price,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'notes' => $this->notes,
            'facility' => [
                'id' => $this->facility->id,
                'name' => $this->facility->name,
                'category' => $this->facility->category,
                'city' => $this->facility->city,
                'thumbnail' => \Illuminate\Support\Str::startsWith($this->facility->thumbnail, ['http://', 'https://']) 
                    ? $this->facility->thumbnail 
                    : asset('storage/' . $this->facility->thumbnail),
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}