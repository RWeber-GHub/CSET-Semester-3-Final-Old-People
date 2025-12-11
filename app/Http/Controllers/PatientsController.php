<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Users;

class PatientsController extends Controller
{
    public function index()
    {
        $id = session('userid');

        if (!$id) {
            return redirect('/login')->withErrors(['Please login first.']);
        }

        $patient = Patients::where('UserID', $id)->firstOrFail();
        $user    = Users::where('UserID', $id)->firstOrFail();

        $today = now()->toDateString();

        $activity = $patient->activity()
            ->with(['doctor', 'caregiver'])
            ->whereDate('Date', $today)
            ->first();

        if (!$activity) {
            $activity = (object)[
                'doctor' => (object)['First_Name' => 'No Doctor Assigned', 'Last_Name' => ''],
                'caregiver' => (object)['First_Name' => 'No Caregiver Assigned', 'Last_Name' => ''],
                'Appointment' => 0,
                'Morning_Meds' => 0,
                'Afternoon_Meds' => 0,
                'Nighttime_Meds' => 0,
                'Breakfast' => 0,
                'Lunch' => 0,
                'Dinner' => 0,
            ];
        }
        $percent = $this->progress($activity);

        return view('PatientsHome', [
            'patient' => $patient,
            'patient_home_activity' => $activity,
            'date' => $today,
            'percent' => $percent,
            'user' => $user,
        ]);

    }

    public function get_activity(Request $request, Patients $patient)
    {
        $id = session('userid');
        $user = Users::where('UserID', $id)->firstOrFail();
        $date = $request->input('date') ?? now()->toDateString(); 
        $patient->load(['user','activity' => function ($query) use ($date){
            $query->whereDate('Date', $date);},
            'activity.doctor',
            'activity.caregiver',
        ]);
        $activity = $patient->activity->first();

        if (!$activity) {
            $activity = (object)[
                'doctor' => (object)['First_Name' => 'No Doctor Assigned', 'Last_Name' => ''],
                'caregiver' => (object)['First_Name' => 'No Caregiver Assigned', 'Last_Name' => ''],
                'Appointment' => 0,
                'Morning_Meds' => 0,
                'Afternoon_Meds' => 0,
                'Nighttime_Meds' => 0,
                'Breakfast' => 0,
                'Lunch' => 0,
                'Dinner' => 0,
            ];
        }

        $percent = $this->progress($activity);

        return view('PatientsHome', [
            'patient' => $patient,
            'patient_home_activity' => $activity,
            'date' => $date,
            'percent' => $percent,
            'user' => $user,
        ]);

    }

    private function progress($activity)
    {
        if (!$activity) {
            return 0;
        }

        $tasks = [
            $activity->Appointment,
            $activity->Morning_Meds,
            $activity->Afternoon_Meds,
            $activity->Nighttime_Meds,
            $activity->Breakfast,
            $activity->Lunch,
            $activity->Dinner,
        ];

        $completed = collect($tasks)->filter(fn($v) => $v == 1)->count();
        $total = count($tasks);

        if ($total === 0) {
            return 0;
        }

        return round(($completed / $total) * 100);
    }

    public function additionalInfoPage()
    {
        return view('Additional_information');
    }

    public function ajaxGetPatientName($id)
    {
        $patient = Patients::where('PatientID', $id)
            ->with('user')
            ->first();

        if (!$patient || !$patient->user){
            return response()->json([
                'name' => null,
                'created_at' => null,
                'group' => null
            ]);
        }

        return response()->json([
            'name' => $patient->user->First_Name.' '.$patient->user->Last_Name,
            'created_at' => $patient->user->created_at->format('Y-m-d'),
            'group' => $patient->user->User_Group
        ]);

    }

    public function saveAdditionalInfo(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'group' => 'nullable|string',
            'admission_date' => 'required|date',
        ]);

        $patientRecord = Patients::where('PatientID', $request->patient_id)->first();

        if (!$patientRecord) {
            return back()->with('error', 'Patient not found.');
        }

        $user = Users::find($patientRecord->UserID);

        $user->User_Group = array_map('trim', explode(',', $request->group));
        $user->save();

        $patientRecord->Admission_Date = $request->admission_date;
        $patientRecord->save();

        return redirect('/admin_home');
    }
}
