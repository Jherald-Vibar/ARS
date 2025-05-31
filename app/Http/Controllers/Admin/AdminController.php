<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard');
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
        ]);

        return redirect()->back()->with('success', "Staff Successfully Created!");
    }
}
