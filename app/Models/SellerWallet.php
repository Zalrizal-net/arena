<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'pending_balance',
        'available_balance',
        'total_income',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}