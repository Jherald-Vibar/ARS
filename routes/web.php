<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StripeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Passenger\PassengerController;
use App\Http\Controllers\Staff\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('voyair_airlines_landing-page');
})->name('landing-page');

//Auth

Route::get('login', [AuthController::class, 'loginForm'])->name('loginForm');
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('register', [AuthController::class,  'accountStore'])->name('passenger-store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth:passenger', 'no.cache'], 'prefix' => 'passenger'], function() {
    Route::get('homepage', [PassengerController::class, 'homepage'])->name('passenger-dashboard');
    Route::get('booking/{fid}', [PassengerController::class, 'bookingPage'])->name('passenger-booking');
    Route::post('booking-store/{fid}', [PassengerController::class, 'bookingStore'])->name('passenger-booking-store');

    //Payment
    Route::get('payment/{bid}', [StripeController::class, 'showForm'])->name('stripe-form');
    Route::post('payment-stripe/{bid}', [StripeController::class, 'processStripePayment'])->name('payment-stripe');
});


Route::group(['middleware' => ['auth', 'no.cache'], 'prefix' => 'admin'], function() {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
    Route::get('staff-list', [AdminController::class, 'staffIndex'])->name('admin-staff-list');
    Route::post('staff-store', [AdminController::class, 'staffStore'])->name('admin-staff-store');
    Route::get('aircraft', [AdminController::class, 'aircraftIndex'])->name('admin-aircraft-list');
    Route::post('aircraft', [AdminController::class, 'aircraftStore'])->name('admin-aircraft-store');
    Route::get('airport', [AdminController::class, 'airportIndex'])->name('admin-airport-list');
    Route::post('airport', [AdminController::class, 'airportStore'])->name('admin-airport-store');
});

Route::group(['middleware' => ['auth:staff', 'no.cache'], 'prefix' => 'staff'], function() {
    Route::get('dashboard', [StaffController::class, 'index'])->name('staff-dashboard');

    //Flight
    Route::get('flights', [StaffController::class, 'flightIndex'])->name('staff-flights-list');
    Route::post('flights', [StaffController::class, 'flightStore'])->name('staff-flights-store');
});

