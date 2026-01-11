<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function updateStaff(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $staff = Staff::findOrFail($id);
        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        $staff->save();

        return redirect()->back()->with('success', 'Staff updated successfully.');

    }

    public function deleteStaff($id){
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->back()->with('success', 'Staff deleted successfully.');

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

    public function updateAircraft(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'model' => 'required|string',
            'manufacturer' => 'required|string',
            'seat_capacity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $aircraft = Aircraft::findOrFail($id);
        $aircraft->update([
            'model' => $validated['model'],
            'manufacturer' => $validated['manufacturer'],
            'seat_capacity' => $validated['seat_capacity'],
        ]);

        return redirect()->back()->with('success', 'Aircraft Successfully Updated!');

    }

        public function deleteAircraft($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        $aircraft->delete();

        return redirect()->back()->with('success', 'Aircraft deleted successfully!');
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

    public function updateAirport(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'country' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $airport = Airport::findOrFail($id);
        $airport->update([
            'name' => $validated['name'],
            'city' => $validated['city'],
            'country' => $validated['country'],
        ]);

        return redirect()->back()->with('success', 'Airport Update Successfully!');

    }

    public function deleteAirport($id){

        $airport = Airport::findOrFail($id);
        $airport->delete();

        return redirect()->back()->with('success', 'Airport Deleted Successfully!');
    }

    public function accSettings(){

        return view('admin.accsettings');
    }

    public function updatePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Account updated successfully');
    }

    public function accProfile(){

        return view('admin.accprofile');
    }
}
