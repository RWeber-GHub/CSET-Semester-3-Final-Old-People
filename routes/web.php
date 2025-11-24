<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\New_Roster_Controller;

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
    return view('Home');
});

Route::get('/patient_home',  [PatientsController::class, 'index']);

Route::get('/signin', function () {
    return view('SignIn');
});


Route::get('/roster', [RosterController::class, 'index'])->name('roster.index');

Route::get('/new-roster', [New_Roster_Controller::class, 'index'])->name('roster.new');

Route::post('/new-roster', [New_Roster_Controller::class, 'store'])->name('roster.store');