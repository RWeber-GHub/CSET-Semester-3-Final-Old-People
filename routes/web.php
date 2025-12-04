<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication_controller;
use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\New_Roster_Controller;

// ---------------- Home ----------------
Route::get('/', function () {
    return view('Home');
});

// Patient Home
Route::get('/patient_home', [PatientsController::class, 'index'])
    ->name('patient.home');

Route::post('/patient/{patient}/prescription', [PatientsController::class, 'get_prescription'])
    ->name('patient.prescription');
// ---------------- Authentication Routes ----------------

// Show login page
Route::get('/login', [Authentication_controller::class, 'showLoginForm'])
    ->name('login');

// Handle login
Route::post('/login', [Authentication_controller::class, 'login'])
    ->name('login.submit');

// Logout
Route::get('/logout', [Authentication_controller::class, 'logout'])
    ->name('logout');

// Show register page
Route::get('/register', [Authentication_controller::class, 'showRegisterForm'])
    ->name('register');

// Handle register
Route::post('/register', [Authentication_controller::class, 'register'])
    ->name('register.submit');


// ---------------- Admin Pages (Protected by ISeeAll Middleware) ----------------

// Admin Home Dashboard
Route::get('/admin_home', function () {
    return view('admin_home');
})->middleware('ISeeAll')->name('admin.home');

// Show list of users waiting for approval
Route::get('/admin/users', [Authentication_controller::class, 'adminUserView'])
    ->middleware('ISeeAll')
    ->name('admin.users');

// Approve user
Route::post('/admin/users/approve/{id}', [Authentication_controller::class, 'approveUser'])
    ->middleware('ISeeAll')
    ->name('admin.user.approve');

// Delete user
Route::delete('/admin/users/delete/{id}', [Authentication_controller::class, 'deleteUser'])
    ->middleware('ISeeAll')
    ->name('admin.user.delete');


// ---------------- Roster ----------------

Route::get('/roster', [RosterController::class, 'index'])
    ->name('roster.index');

Route::get('/new-roster', [New_Roster_Controller::class, 'index'])->name('newRoster.index');

Route::post('/new-roster', [New_Roster_Controller::class, 'store'])->name('newRoster.store');

