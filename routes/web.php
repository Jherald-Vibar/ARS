<?php

use App\Http\Controllers\Admin\AdminController;
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


Route::group(['middleware' => 'auth:passenger', 'prefix' => 'passenger'], function() {
    Route::get('homepage', [PassengerController::class, 'homepage'])->name('passenger-dashboard');
});


Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
    Route::get('staff-list', [AdminController::class, 'staffIndex'])->name('admin-staff-list');
    Route::post('staff-store', [AdminController::class, 'staffStore'])->name('admin-staff-store');
});

Route::group(['middleware' => 'auth:staff', 'prefix' => 'staff'], function() {
    Route::get('dashboard', [StaffController::class, 'index'])->name('staff-dashboard');
});

