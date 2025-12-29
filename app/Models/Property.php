<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyImage;
use App\Models\Booking;
use App\Models\User;

class Property extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'location',
        'price',
        'description',
        'province',
        'city',
        'district',
        'address',
        'facilities',
        'custom_facilities'
    ];

    protected $casts = [
        'facilities' => 'array',
        'custom_facilities' => 'array'
    ];

    // ===== RELASI OWNER =====
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // ===== RELASI FOTO =====
    public function images()
    {
        return $this->hasMany(PropertyImage::class)
            ->orderByDesc('is_main')   // foto utama dulu
            ->orderBy('id');           // lalu urut biasa
    }

    // ===== RELASI BOOKING =====
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
