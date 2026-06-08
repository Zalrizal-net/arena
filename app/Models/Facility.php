<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'seller_id',
        'name',
        'slug',
        'category',
        'city',
        'address',
        'description',
        'price_per_hour',
        'thumbnail',
        'status',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relasi ke penjual (User)
     * Satu fasilitas dimiliki oleh satu penjual (seller).
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Relasi ke galeri gambar
     * Satu fasilitas memiliki banyak gambar.
     */
    public function images()
    {
        return $this->hasMany(FacilityImage::class, 'facility_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'facility_id');
    }
    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }
    public function schedules()
    {
        return $this->hasMany(\App\Models\Schedule::class, 'facility_id');
    }

    /**
     * Relasi ke tabel reviews (Satu Fasilitas punya Banyak Ulasan)
     */
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'facility_id');
    }
}