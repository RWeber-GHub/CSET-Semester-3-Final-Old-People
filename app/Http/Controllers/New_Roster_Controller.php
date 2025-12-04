<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Roster;

class New_Roster_Controller extends Controller
{
    public function index()
    {
        $supervisors = Users::where('RoleID', '6')->get();
        $doctors     = Users::where('RoleID', '2')->get();
        $caregivers  = Users::where('RoleID', '4')->get();

        return view('NewRoster', [
            'supervisors' => $supervisors,
            'doctors' => $doctors,
            'caregivers' => $caregivers,
        ]);
    }

    public function store(Request $request)
    {
         Roster::create([
        'Date'         => $request->date,
        'SupervisorID' => $request->supervisor_id,
        'DoctorID'     => $request->doctor_id,
        'Caregiver1_ID' => $request->cg1_id,
        'Caregiver2_ID' => $request->cg2_id,
        'Caregiver3_ID' => $request->cg3_id,
        'Caregiver4_ID' => $request->cg4_id,
    ]);

    return redirect('/roster?date=' . $request->date)
           ->with('success', 'Roster created successfully!');
    }
}
