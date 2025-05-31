<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number', 'aircraft_id', 'departure_airport_id', 'arrival_airport_id',
        'departure_date', 'arrival_date', 'arrival_time', 'departure_time',
        'first_class_ticket_price', 'business_class_ticket_price', 'economy_class_ticket_price', 'status'
    ];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }
}
