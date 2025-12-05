<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Prescriptions;

class PatientsController extends Controller
{
    public function index()
    {
        $id = session('userid');

        if (!$id) {
            return redirect('/login')->withErrors(['Please login first.']);
        }
        $patient = Patients::where('UserID', $id)->firstOrFail();

        $today = today()->toDateString();
        $prescription = $patient->prescriptions()->whereDate('Date', $today)->first();
        $patient_home_activity = $patient->activity()->whereDate('Date', $today)->first();

        return view('PatientsHome', [
            'patient' => $patient,
            'prescription' => $prescription,
            'patient_home_activity' => $patient_home_activity,
            'date' => $today,
        ]);
    }
    
    public function patient_home(Patients $patient)
    {
        $today = today()->toDateString();

        $prescription = $patient->prescriptions()->whereDate('Date', $today)->first();
        
        $patient_home_activity = $patient->activity()->whereDate('Date', $today)->first();

        return view('PatientsHome', [
            'patient' => $patient,
            'prescription' => $prescription,
            'patient_home_activity' => $patient_home_activity,
            'date' => $today,
        ]);
    }

    public function get_prescription(Request $request, Patients $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);
        $date = $validated['date'];

        $prescription = $patient->prescriptions()->whereDate('Date', $date)->first();
        $activity = $patient->activity()->whereDate('Date', $date)->first();

        return view('PatientsHome', [
            'patient' => $patient,
            'prescription' => $prescription,
            'patient_home_activity' => $activity,
            'date' => $date,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
