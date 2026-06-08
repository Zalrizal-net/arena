<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category,
            'city' => $this->city,
            'address' => $this->address,
            'description' => $this->description,
            'price_per_hour' => (float) $this->price_per_hour,
            'thumbnail_url' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'status' => $this->status,
            'latitude' => $this->latitude ? (float) $this->latitude : null,
            'longitude' => $this->longitude ? (float) $this->longitude : null,
            'gallery' => $this->images->map(fn($img) => asset('storage/' . $img->image_path)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}