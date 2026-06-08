<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;

    // Mematikan updated_at karena tabel ini hanya butuh created_at
    public $timestamps = false; 

    protected $fillable = [
        'review_id',
        'image_path',
        'created_at',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}   