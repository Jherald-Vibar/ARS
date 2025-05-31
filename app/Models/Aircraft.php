<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $fillable = ['model', 'manufacturer', 'seat_capacity'];

    public function flights()
    {
        return $this->hasMany(Flights::class);
    }
}
