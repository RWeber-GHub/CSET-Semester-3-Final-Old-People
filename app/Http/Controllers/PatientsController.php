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
        $id = session('user_id');
        $patient = Patients::findOrFail($id);
        return view('PatientsHome', compact('patient'));
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

    public function prescription(Request $request, Patients $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $prescription = $patient->prescriptions()->whereDate('date', $validated['date'])->first();

        return $prescription;
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
