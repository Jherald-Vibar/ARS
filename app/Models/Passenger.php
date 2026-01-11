<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    protected $fillable = [
        'booking_id',
        'full_name',
        'contact_number',
        'email',
        'passport_number',
        'seat_number',
        'seat_class',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function boardingPasses()
    {
    return $this->hasMany(BoardingPass::class);
    }
}
