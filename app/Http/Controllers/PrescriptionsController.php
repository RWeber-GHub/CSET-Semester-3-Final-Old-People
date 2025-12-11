<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionsController extends Controller
{
    // Show create prescription page for appointment {id}
    public function createForm($id)
    {
        // ensure appointment exists
        $appointment = DB::table('appointments')->where('AppointmentID', $id)->first();
        if (!$appointment) {
            return redirect('/')->withErrors('Appointment not found.');
        }

        // load appointment + patient + doctor info
        $patient = DB::table('users')->where('UserID', $appointment->PatientID)->first();
        $doctor = DB::table('users')->where('UserID', $appointment->DoctorID)->first();

        return view('prescriptions.create', [
            'appointment' => $appointment,
            'patient' => $patient,
            'doctor' => $doctor
        ]);
    }

    // Store a prescription linked to appointment
    public function store(Request $request, $id)
    {
        $request->validate([
            'prescription_details' => 'required|string|max:1000',
            'date' => 'nullable|date',
        ]);

        // ensure appointment exists
        $appointment = DB::table('appointments')->where('AppointmentID', $id)->first();
        if (!$appointment) {
            return redirect('/')->withErrors('Appointment not found.');
        }

        // Insert prescription, link to appointment
        $prescriptionId = DB::table('prescriptions')->insertGetId([
            'DoctorID' => $appointment->DoctorID,
            'PatientID' => $appointment->PatientID,
            'AppointmentID' => $appointment->AppointmentID,
            'Date' => $request->date ? date('Y-m-d H:i:s', strtotime($request->date)) : date('Y-m-d H:i:s'),
            'Prescription_Details' => $request->prescription_details,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect('/admin_home')->with('success', 'Prescription saved and linked to appointment.');
    }
}
