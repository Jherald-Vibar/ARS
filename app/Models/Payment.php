<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'booking_id',
        'amount_paid',
        'payment_method',
        'payment_date',
        'payment_status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function receipt()
    {
    return $this->hasOne(Receipt::class, 'payment_id');
    }
}
