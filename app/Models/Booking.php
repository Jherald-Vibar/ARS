<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

     protected $fillable = [
        'account_id',
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

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


    public function calculateAmount($bookingId)
    {
        $booking = Booking::with(['passengers', 'flight'])->findOrFail($bookingId);
        $flight = $booking->flight;

        $totalAmount = 0;

        foreach ($booking->passengers as $passenger) {
            switch ($passenger->seat_class) {
                case 'first':
                    $totalAmount += $flight->first_class_ticket_price;
                    break;
                case 'business':
                    $totalAmount += $flight->business_class_ticket_price;
                    break;
                case 'economy':
                default:
                    $totalAmount += $flight->economy_class_ticket_price;
                    break;
            }
        }

        return $totalAmount;
    }
}
