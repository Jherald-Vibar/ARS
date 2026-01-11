<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\Flights;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index() {
        $totalFlights = Flights::count();
        $totalBookings = Booking::count();
        $bookings = Booking::all();
        $totalAmount = [
            'Monday'    => Payment::whereDay('created_at', 1)->sum('amount_paid'),
            'Tuesday'   => Payment::whereDay('created_at', 2)->sum('amount_paid'),
            'Wednesday' => Payment::whereDay('created_at', 3)->sum('amount_paid'),
            'Thursday'  => Payment::whereDay('created_at', 4)->sum('amount_paid'),
            'Friday'    => Payment::whereDay('created_at', 5)->sum('amount_paid'),
            'Saturday'  => Payment::whereDay('created_at', 6)->sum('amount_paid'),
            'Sunday'    => Payment::whereDay('created_at', 0)->sum('amount_paid'),
        ];
        return view('staff.dashboard', compact('totalFlights', 'totalBookings','bookings', 'totalAmount'));
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

        public function flightUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'aircraft_id' => 'required',
            'departure_airport_id' => 'required',
            'arrival_airport_id' => 'required',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required',
            'first_class_ticket_price' => 'required|numeric',
            'business_class_ticket_price' => 'required|numeric',
            'economy_class_ticket_price' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $flight = Flights::findOrFail($id);
        $validated = $validator->validated();

        $flight->update([
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

        return redirect()->back()->with('success', 'Flight Successfully Updated!');
    }

    public function flightDelete($id){

        $flight = Flights::findOrFail($id);

        $flight->delete();

        return redirect()->back()->with('success', 'Flight Successfully Deleted!');
    }

    public function bookingPage() {
        $bookings = Booking::all();
        return view('staff.booking', compact('bookings'));
    }


}
