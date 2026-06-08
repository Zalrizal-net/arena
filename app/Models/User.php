<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user has an admin role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has a seller role.
     *
     * @return bool
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    /**
     * Check if the user has a buyer role.
     *
     * @return bool
     */
    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
    public function wallet()
    {
        return $this->hasOne(SellerWallet::class, 'seller_id');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'seller_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'seller_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class, 'user_id');
    }
    public function facilities()
    {
        return $this->hasMany(Facility::class, 'seller_id'); 
    }
}