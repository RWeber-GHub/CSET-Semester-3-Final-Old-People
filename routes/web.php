<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication_controller;
use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\New_Roster_Controller;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SupervisorController;

// ---------------- Home ----------------
Route::get('/', function () {
    return view('Home');
});

// Patient Home
Route::get('/patient_home', [PatientsController::class, 'index'])
    ->name('patient.home');

Route::get('/patient/{patient}/activity', [PatientsController::class, 'get_activity'])
    ->name('patient.activity');

Route::get('/patient-info', [PatientsController::class, 'additionalInfoPage'])
    ->name('patient.info');

Route::post('/patient-info/save', [PatientsController::class, 'saveAdditionalInfo'])
    ->name('patient.info.save');

Route::get('/ajax/patient-name/{id}', 
    [PatientsController::class, 'ajaxGetPatientName']);
// Caregiver Home
Route::get('/caregiver_home', [CaregiverController::class, 'index']);

Route::get('/caregiver/activity', [CaregiverController::class, 'get_activity'])
    ->name('caregiver.activity');

Route::post('/caregiver/update_activity', [CaregiverController::class, 'updateActivity'])
    ->name('caregiver.updateActivity');
// Family Home
Route::get('/family_home', [FamilyController::class, 'index'])
    ->name('family.home');

Route::get('/supervisor_home', [SupervisorController::class, 'index']);

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
Route::get('/admin_home', [Authentication_controller::class, 'adminUserView'])
    ->middleware('ISeeAll')
    ->name('admin.home');

// Show list of users waiting for approval
Route::get('/admin/users', [Authentication_controller::class, 'adminUserView'])
    ->middleware('ISeeAll')
    ->name('admin.users');

Route::get('/admin/users', [Authentication_controller::class, 'adminUserSearch'])->name('admin.users');

// Approve user
Route::post('/admin/users/approve/{id}', [Authentication_controller::class, 'approveUser'])
    ->middleware('ISeeAll')
    ->name('admin.user.approve');

// Delete user
Route::delete('/admin/users/delete/{id}', [Authentication_controller::class, 'deleteUser'])
    ->middleware('ISeeAll')
    ->name('admin.user.delete');

Route::get('/admin/activity', [Authentication_controller::class, 'adminPatientActivity']);
Route::get('/admin/activity/search', [Authentication_controller::class, 'adminPatientActivitySearch']);

// ---------------- Roster ----------------

Route::get('/roster', [RosterController::class, 'index'])
    ->name('roster.index');

Route::get('/new-roster', [New_Roster_Controller::class, 'index'])->name('newRoster.index');

Route::post('/new-roster/store', [New_Roster_Controller::class, 'store'])
    ->name('newRoster.store');
// ------------------- Appointments + lookup helpers (if you are going to change these lookup how to use AJAX please)

Route::get('/appointments/create', [AppointmentController::class, 'createForm'])
    ->name('appointments.create');

Route::post('/appointments', [AppointmentController::class, 'store'])
    ->name('appointments.store');

// AJAX: lookup patient name by id (returns json)
Route::get('/ajax/appointment-patient-name/{id}', [AppointmentController::class, 'ajaxPatientName'])
    ->name('ajax.appointment.patient.name');

// AJAX: fetch rostered doctors for a date (date in YYYY-MM-DD)
Route::get('/ajax/doctors-by-date', [AppointmentController::class, 'ajaxDoctorsByDate'])
    ->name('ajax.doctors.by.date');

// Prescription pages (create for appointment and store)
Route::get('/appointments/{id}/prescriptions/create', [PrescriptionsController::class, 'createForm'])
    ->name('prescriptions.create');

Route::post('/appointments/{id}/prescriptions', [PrescriptionsController::class, 'store'])
    ->name('prescriptions.store');


// ---------------- Doctor ----------------
Route::get('/doctor_home', [DoctorController::class, 'index'])
    ->name('doctor.home');

Route::post('/doctor/appointments/filter', [DoctorController::class, 'filterAppointments'])
    ->name('doctor.filterAppointments');

Route::get('/doctor/patient/{patientID}', [DoctorController::class, 'viewPatient'])
    ->name('doctor.viewPatient');

Route::post('/doctor/prescription/create', [DoctorController::class, 'createPrescription'])
    ->name('doctor.createPrescription');

Route::get('/doctor/appointments', function () {
    return redirect()->route('doctor.home');
})->name('doctor.appointments');

// Employee management 
Route::get(
    '/employees',
    [\App\Http\Controllers\EmployeeController::class, 'index']
)->middleware('ISeeAll')->name('employees.index');

Route::post(
    '/employees/update-salary',
    [\App\Http\Controllers\EmployeeController::class, 'updateSalary']
)->middleware('ISeeAll')->name('employees.updateSalary');






