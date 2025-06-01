<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Flights;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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


    public function flightStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'aircraft_id' => 'required',
            'departure_airport_id' => 'required',
            'arrival_airport_id' => 'required',
            'departure_date' => 'required',
            'departure_time' => 'required',
            'arrival_date' => 'required',
            'arrival_time' => 'required',
            'first_class_ticket_price' => 'required',
            'business_class_ticket_price' => 'required',
            'economy_class_ticket_price' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $departureAirport = Airport::findOrFail($validated['departure_airport_id']);

        $flightNumber = $departureAirport->name . rand(1,99);


        Flights::create([
            'flight_number' => $flightNumber,
            'aircraft_id' => $validated['aircraft_id'],
            'departure_airport_id' => $validated['departure_airport_id'],
            'arrival_airport_id' => $validated['arrival_airport_id'],
            'departure_date' => $validated['departure_date'],
            'departure_time' => $validated['departure_time'],
            'arrival_date' => $validated['arrival_date'],
            'arrival_time' => $validated['arrival_time'],
            'first_class_ticket_price' => $validated['first_class_ticket_price'],
            'business_class_ticket_price' => $validated['business_class_ticket_price'],
            'economy_class_ticket_price' => $validated['economy_class_ticket_price'],
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', "Flight Successfully Created!");
    }
}
