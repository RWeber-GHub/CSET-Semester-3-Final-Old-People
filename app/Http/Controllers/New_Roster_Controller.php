<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;
use App\Models\Users;
use Carbon\Carbon;

class New_Roster_Controller extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());

        $roster = Roster::query()
                        ->whereDate('date', $date)
                        ->with(['supervisor','doctor','cg1','cg2','cg3','cg4'])
                        ->first();

        $users = Users::orderBy('Last_Name')->get();

        return view('NewRoster', compact('date','roster','users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'supervisor_id' => 'nullable|exists:users,UserID',
            'doctor_id' => 'nullable|exists:users,UserID',
            'caregiver1_id' => 'nullable|exists:users,UserID',
            'caregiver2_id' => 'nullable|exists:users,UserID',
            'caregiver3_id' => 'nullable|exists:users,UserID',
            'caregiver4_id' => 'nullable|exists:users,UserID',
            'patient_group1' => 'nullable|string|max:50',
            'patient_group2' => 'nullable|string|max:50',
            'patient_group3' => 'nullable|string|max:50',
            'patient_group4' => 'nullable|string|max:50',
        ]);

        Roster::updateOrCreate(
            ['date' => $data['date']],
            $data
        );

        return redirect()->route('roster.index', ['date' => $data['date']])
                         ->with('success', 'Roster saved.');
    }
}
