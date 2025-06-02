<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }

    public function registerForm() {
        return view('auth.register');
    }

    public function accountStore(Request $request) {

       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:6',
            'address' => 'required',
            'contact_number' => 'required',
            'passport_number' => [
                'required',
                'unique:accounts,passport_number',
                'regex:/^[A-Z]{1}[0-9]{6,7}$/'
            ],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();


        Account::create([
            'name' => $validated['name'],
            'date_of_birth' => $validated['date_of_birth'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'],
            'passport_number' => $validated['passport_number'],
        ]);

        return redirect()->route('loginForm')->with('success', "Account Successfully Created!");
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('passenger')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('passenger-dashboard')->with('success', "Successfully Login!");
        } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin-dashboard')->with('success', "Successfully Login");
        } elseif(Auth::guard('staff')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('staff')->user();
            $user->update(['status' => 'online']);
            return redirect()->route('staff-dashboard')->with('success', "Successfully Login!");
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout() {

        if(Auth::guard('passenger')->check()) {
            Auth::guard('passenger')->logout();
            session()->invalidate();
            session()->regenerateToken();
        } elseif(Auth::guard('staff')->check()) {
            Auth::guard('staff')->user()->update(['status' => 'offline']);
            Auth::guard('staff')->logout();
            session()->invalidate();
            session()->regenerateToken();
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        return redirect()->route('landing-page')->with('success', "Logout Succcessfully!");
    }
}
