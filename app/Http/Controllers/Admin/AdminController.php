<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index() {
        $totalStaffs = Staff::count();
        $staffs = Staff::all();
        return view('admin.dashboard', compact('totalStaffs', 'staffs'));
    }

    public function staffIndex() {
        $staffs = Staff::all();
        return view('admin.staff_list', compact('staffs'));
    }


    public function staffStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:staff,email',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $password = "VOYAIR".$validated['name'];

        Staff::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
            'status' => "offline",
        ]);

        return redirect()->back()->with('success', "Staff Successfully Created!");
    }


    public function aircraftIndex() {
        $aircraft = Aircraft::all();
        return view('admin.aircraft', compact('aircraft'));
    }

    public function aircraftStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'manufacturer' => 'required',
            'seat_capacity' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        Aircraft::create([
            'model' => $validated['model'],
            'manufacturer' => $validated['manufacturer'],
            'seat_capacity' => $validated['seat_capacity'],
        ]);

        return redirect()->back()->with('success', "Aircraft Successfully Created!");
    }

    public function airportIndex() {
        $airports = Airport::all();
        return view('admin.airport', compact('airports'));
    }

    public function airportStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'country' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        Airport::create([
            'name' => $validated['name'],
            'city' => $validated['city'],
            'country' => $validated['country'],
        ]);

        return redirect()->back()->with('success', "Airport Successfully Created!");
    }
}
