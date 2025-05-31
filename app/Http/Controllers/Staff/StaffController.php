<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Flights;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index() {
        return view('staff.dashboard');
    }

    public function flightIndex() {
        $flights = Flights::all();
        $airports = Airport::all();
        $aircrafts = Aircraft::all();
        return view('staff.flight_list', compact('flights', 'airports', 'aircrafts'));
    }
}
