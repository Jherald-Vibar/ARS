<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = ['name', 'city', 'country'];

    public function departures()
    {
        return $this->hasMany(Flights::class, 'departure_airport_id');
    }

    public function arrivals()
    {
        return $this->hasMany(Flights::class, 'arrival_airport_id');
    }
}
