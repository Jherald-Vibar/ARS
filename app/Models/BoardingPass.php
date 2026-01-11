<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingPass extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'flight_id',
        'seat_number',
        'boarding_time',
    ];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flights::class);
    }
}
