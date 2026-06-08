<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_slug',
        'logo',
        'banner',
        'description',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}