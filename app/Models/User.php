<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'role',
        'password',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function chatsAsUser()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function chatsAsOwner()
    {
        return $this->hasMany(Chat::class, 'owner_id');
    }
}
