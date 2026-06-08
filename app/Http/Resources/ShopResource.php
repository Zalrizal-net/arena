<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'seller_name' => $this->user->name ?? 'Pengguna',
            'shop_name'   => $this->shop_name,
            'shop_slug'   => $this->shop_slug,
            'logo'        => $this->logo ? asset('storage/' . $this->logo) : null,
            'banner'      => $this->banner ? asset('storage/' . $this->banner) : null,
            'description' => $this->description,
            'city'        => $this->city,
            'joined_at'   => $this->created_at->format('Y-m-d'),
            'joined_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}