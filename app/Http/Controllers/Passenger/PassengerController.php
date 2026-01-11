<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Flights;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

class PassengerController extends Controller
{
    public function homepage(Request $request) {
        $flights = Flights::query();

        if ($request->filled('from')) {
        $flights->whereHas('departureAirport', function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->from . '%');
        });
        }

        if ($request->filled('to')) {
            $flights->whereHas('arrivalAirport', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->to . '%');
            });
        }

        if ($request->filled('departing')) {
            $flights->whereDate('departure_time', $request->departing);
        }


        $flights = $flights->with(['departureAirport', 'arrivalAirport'])
                       ->orderBy('departure_time')
                       ->paginate(10);

        $upcomingFlights = Flights::where('departure_date', '>=' , today())->get();
        return view('passenger.homepage', compact('flights', 'upcomingFlights'));
    }

    public function bookingPage($fid) {
        $user = Auth::guard('passenger')->user();
        $flight = Flights::with('aircraft')->findOrFail($fid);
        $bookedSeat = Passenger::whereHas('booking', function ($query) use ($flight) {
        $query->where('flight_id', $flight->id)->where('status', 'confirmed');
         })->pluck('seat_number')->toArray();
         $title = "Home - Booking";
        return view('passenger.booking', compact('flight', 'user', 'bookedSeat', 'title'));
    }

    public function bookingStore(Request $request, $fid) {
        $user = Auth::guard('passenger')->user();
        $flight = Flights::findOrFail($fid);

        $validator = Validator::make($request->all(), [
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.mobile_number' => 'required|string|max:20',
            'passengers.*.email' => 'required|email|max:255',
            'passengers.*.passport_number' => 'required|string|max:100',
            'passengers.*.seat' => 'required|string|max:10',
            'passengers.*.seat_class' => 'required',
        ]);



        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $validated = $validator->validated();



        $hasBooked = Booking::where('account_id', $user->id)->where('flight_id', $flight->id)->where('status', 'confirmed')->first();

        if($hasBooked) {
            return redirect()->back()->with('error', "Already Book!");
        }

        $booking = Booking::create([
            'account_id' => $user->id,
            'flight_id' => $flight->id,
            'booking_reference' => strtoupper(Str::random(10)),
            'booking_date' => now(),
            'total_passenger' => count($validated['passengers']),
            'status' => 'pending',
        ]);

        foreach ($request->passengers as $passengerData) {
            $booking->passengers()->create([
                'full_name' => $passengerData['name'],
                'contact_number' => $passengerData['mobile_number'],
                'email' => $passengerData['email'],
                'passport_number' => $passengerData['passport_number'],
                'seat_number' => $passengerData['seat'],
                'seat_class' => $passengerData['seat_class'],
            ]);
        }

        return redirect()->route('stripe-form', ['bid' => $booking->id])->with('notice', "Please pay!");
        //return redirect()->back()->with('success', "Booking Success!");
    }
}
