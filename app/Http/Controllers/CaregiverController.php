<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Patients;
use App\Models\PatientHomeActivity;
use Illuminate\Support\Facades\DB;


class CaregiverController extends Controller
{
    public function index()
    {
        $id = session('userid');
        if (!$id) {
            return redirect('/login')->withErrors(['Please login first.']);
        }
        
        $caregiver = Users::where('UserID', $id)->firstOrFail();
        $today = today()->toDateString();

        $InRoster = DB::table('roster')
            ->whereDate('Date', $today)
            ->where(function ($q) use ($id) {
                $q->where('Caregiver1_ID', $id)
                ->orWhere('Caregiver2_ID', $id)
                ->orWhere('Caregiver3_ID', $id)
                ->orWhere('Caregiver4_ID', $id);
            })
            ->first();
        
        if (!$InRoster){
            $error = "No Roster Planned for Today $today";
            return view('CaregiversHome', [
                'caregiver' => $caregiver,
                'date' => $today,
                'error' => $error,
            ]);
        }
        $patients = Patients::with(['activity' => function ($query) use ($today) {
            $query->whereDate('Date', $today);
        }])->get();

        $prescriptionsToday = DB::table('prescriptions')
            ->join('appointments', 'prescriptions.AppointmentID', '=', 'appointments.AppointmentID')
            ->whereDate('appointments.Date', $today)
            ->pluck('appointments.PatientID')
            ->unique()
            ->toArray();

        return view('CaregiversHome', [
            'caregiver' => $caregiver,
            'patients' => $patients,
            'date' => $today,
            'prescriptionsToday' => $prescriptionsToday
        ]);
    }

    public function get_activity(Request $request)
    {
        $id = session('userid');
        $caregiver = Users::where('UserID', $id)->firstOrFail();
        $date = $request->input('date') ?? now()->toDateString();   

        $InRoster = DB::table('roster')
            ->whereDate('Date', $date)
            ->where(function ($q) use ($id) {
                $q->where('Caregiver1_ID', $id)
                ->orWhere('Caregiver2_ID', $id)
                ->orWhere('Caregiver3_ID', $id)
                ->orWhere('Caregiver4_ID', $id);
            })
            ->first();
        
        if (!$InRoster){
            $error = 'No Roster Planned for Today';
            return view('CaregiversHome', [
                'caregiver' => $caregiver,
                'date' => $date,
                'error' => $error,
            ]);
        }

        $patients = Patients::with([
            'user', 
            'activity' => function ($query) use ($date){
                $query->whereDate('Date', $date);
        }])->get();

        $prescriptionsToday = DB::table('prescriptions')
            ->join('appointments', 'prescriptions.AppointmentID', '=', 'appointments.AppointmentID')
            ->whereDate('appointments.Date', $date)
            ->pluck('appointments.PatientID')
            ->unique()
            ->toArray();

        return view('CaregiversHome', [
            'caregiver' => $caregiver,
            'patients' => $patients,
            'date' => $date,
            'prescriptionsToday' => $prescriptionsToday
        ]);
    }

    public function updateActivity(Request $request)
    {
        $caregiverId = session('userid');

        // Make sure we always have an array
        $activityIds = $request->input('activities', []);

        foreach ($activityIds as $activityId) {

            $activity = PatientHomeActivity::find($activityId);
            if (!$activity) continue;

            // For checkbox arrays: isset(...) means checked
            $activity->Appointment     = isset($request->Appointment[$activityId]);
            $activity->Morning_Meds    = isset($request->Morning_Meds[$activityId]);
            $activity->Afternoon_Meds  = isset($request->Afternoon_Meds[$activityId]);
            $activity->Nighttime_Meds  = isset($request->Nighttime_Meds[$activityId]);
            $activity->Breakfast       = isset($request->Breakfast[$activityId]);
            $activity->Lunch           = isset($request->Lunch[$activityId]);
            $activity->Dinner          = isset($request->Dinner[$activityId]);

            $activity->CaregiverID = $caregiverId;

            $activity->save();
        }

        return back()->with('success', 'All activities updated!');

    }
}
