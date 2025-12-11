<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Roster;
use Illuminate\Support\Facades\DB;

class New_Roster_Controller extends Controller
{
    public function index()
    {
        $supervisors = Users::where('RoleID', '6')->get();
        $doctors     = Users::where('RoleID', '2')->get();
        $caregivers  = Users::where('RoleID', '4')->get();

        $cgGroups = [];
        foreach ($caregivers as $cg){
            $decoded = json_decode($cg->User_Group, true);
            if (is_array($decoded)) {
                $cgGroups[$cg->UserID] = $decoded;
            } elseif (is_string($cg->User_Group) && $cg->User_Group !== "") {
                $cgGroups[$cg->UserID] = [$cg->User_Group];
            } else {
                $cgGroups[$cg->UserID] = [];
            }
        }
        $groups = Users::whereNotNull('User_Group')
            ->pluck('User_Group')
            ->map(function ($value){
                $decoded = json_decode($value, true);
                if (is_array($decoded)) return $decoded;
                if (is_string($value) && $value !== "") return [$value];
                return [];

            })
            ->flatten()
            ->unique()
            ->values();

        return view('NewRoster', [
            'supervisors' => $supervisors,
            'doctors'     => $doctors,
            'caregivers'  => $caregivers,
            'groups'      => $groups,
            'cgGroups'    => $cgGroups,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'supervisor_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'cg1_id' => 'required|integer',
        ]);

        Roster::whereDate('Date', $request->date)->delete();

        Roster::create([
            'Date'          => $request->date,
            'SupervisorID'  => $request->supervisor_id,
            'DoctorID'      => $request->doctor_id,
            'Caregiver1_ID' => $request->cg1_id,
            'Caregiver2_ID' => $request->cg2_id,
            'Caregiver3_ID' => $request->cg3_id,
            'Caregiver4_ID' => $request->cg4_id,

            'CG1_Groups' => json_encode($request->cg1_group ?? []),
            'CG2_Groups' => json_encode($request->cg2_group ?? []),
            'CG3_Groups' => json_encode($request->cg3_group ?? []),
            'CG4_Groups' => json_encode($request->cg4_group ?? []),
        ]);

        $this->updateCaregiverGroups($request->cg1_id, $request->cg1_group ?? []);
        $this->updateCaregiverGroups($request->cg2_id, $request->cg2_group ?? []);
        $this->updateCaregiverGroups($request->cg3_id, $request->cg3_group ?? []);
        $this->updateCaregiverGroups($request->cg4_id, $request->cg4_group ?? []);
        $this->createDailyPatientActivity(
            $request->date,
            $request->doctor_id,
            [
                $request->cg1_id,
                $request->cg2_id,
                $request->cg3_id,
                $request->cg4_id
            ]
        );
        return redirect('/roster?date=' . $request->date);
    }
    private function updateCaregiverGroups($caregiverId, $newGroups)
    {
        if (!$caregiverId) return;

        $user = Users::find($caregiverId);
        if (!$user) return;

        $user->User_Group = json_encode($newGroups);
        $user->save();
    }

    private function createDailyPatientActivity($date, $doctorId, $caregiverIds)
    {
        // Filter null caregivers
        $caregiverIds = array_filter($caregiverIds);

        // Load caregiver groups
        $caregivers = Users::whereIn('UserID', $caregiverIds)
            ->where('RoleID', 4)
            ->get(['UserID', 'User_Group']);

        $caregivers = $caregivers->map(function ($cg) {
            $groups = json_decode($cg->User_Group, true);
            if (!is_array($groups)) $groups = [];
            return [
                'id'     => $cg->UserID,
                'groups' => $groups
            ];
        });

        // Load ALL patients with their groups
        $patients = DB::table('patients')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->select('patients.PatientID', 'users.User_Group')
            ->get();

        foreach ($patients as $patient) {

            // Prevent duplicate activity entries
            $exists = DB::table('patient_home_activity')
                ->where('PatientID', $patient->PatientID)
                ->whereDate('Date', $date)
                ->exists();

            if ($exists) continue;

            // Decode patient groups
            $patientGroups = json_decode($patient->User_Group, true);
            if (!is_array($patientGroups)) $patientGroups = [];

            // Try to match caregiver by group
            $assignedCg = null;

            foreach ($caregivers as $cg) {
                if (count(array_intersect($cg['groups'], $patientGroups)) > 0) {
                    $assignedCg = $cg['id'];
                    break;
                }
            }

            // Fallback to first caregiver
            if (!$assignedCg) {
                $assignedCg = $caregiverIds[0] ?? null;
            }

            // INSERT activity row
            DB::table('patient_home_activity')->insert([
                'PatientID'      => $patient->PatientID,
                'DoctorID'       => $doctorId,
                'CaregiverID'    => $assignedCg,
                'Date'           => $date . ' 00:00:00',

                'Appointment'    => false,
                'Morning_Meds'   => false,
                'Afternoon_Meds' => false,
                'Nighttime_Meds' => false,
                'Breakfast'      => false,
                'Lunch'          => false,
                'Dinner'         => false,

                'Comments'       => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
