<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'facility_id',
        'image_path',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Relasi balik ke fasilitas
     * Satu gambar ini milik satu fasilitas tertentu.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'facility_id');
    }
}