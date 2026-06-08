<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facility_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration',
        'total_price',
        'booking_code',
        'status',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
        'duration' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function review()
    {
        // 1 Booking hanya bisa memiliki 1 Review
        return $this->hasOne(Review::class); 
    }
}