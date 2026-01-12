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
        'gender_type',
        'facilities',
        'custom_facilities'
    ];

    protected $casts = [
        'facilities' => 'array',
        'custom_facilities' => 'array'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)
            ->orderByDesc('is_main')   
            ->orderBy('id');          
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
