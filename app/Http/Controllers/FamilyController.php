<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Users;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $id = session('userid');
        $family = Users::findOrFail($id);

        $patients = Patients::where('Family_Code', $family->Family_Code)->with('user')->get();

        $selectedPatient = null;
        $patient_home_activity  = null;
        $date = $request->input('date') ?? today()->toDateString();

        if ($request->patient){
            $selectedPatient = Patients::where('PatientID', $request->patient)->where('Family_Code', $family->Family_Code)->with([
            'user',
            'activity' => function ($query) use ($date){
                $query->whereDate('Date', $date);
            },
            'activity.doctor',
            'activity.caregiver',
            ])->first();
            if ($selectedPatient){
                $patient_home_activity = $selectedPatient->activity->first();
            }
        }

        return view('FamilyMembersHome', [
            'family' => $family,
            'patients' => $patients,
            'selectedPatient' => $selectedPatient,
            'patient_home_activity' => $patient_home_activity,
            'date' => $date
        ]);
    }
}
