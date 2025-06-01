<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'flight_id',
        'booking_reference',
        'booking_date',
        'total_passenger',
        'status',
    ];

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
     public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flights::class);
    }
}
