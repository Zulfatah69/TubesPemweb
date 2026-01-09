<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> zulfatah
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
<<<<<<< HEAD
    protected $fillable = [
        'user_id','property_id','start_date','note','status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function property(){
        return $this->belongsTo(Property::class);
    }
=======
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'start_date',
        'months',
        'total_price',
        'note',
        'status',
        'payment_status',
        'midtrans_order_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
>>>>>>> zulfatah
}
