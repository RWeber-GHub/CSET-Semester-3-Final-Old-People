<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roster;
use Illuminate\Support\Facades\DB;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));

        $roster = DB::table('roster')
            ->leftJoin('users as sup', 'sup.UserID', '=', 'roster.SupervisorID')
            ->leftJoin('users as doc', 'doc.UserID', '=', 'roster.DoctorID')
            ->leftJoin('users as cg1', 'cg1.UserID', '=', 'roster.Caregiver1_ID')
            ->leftJoin('users as cg2', 'cg2.UserID', '=', 'roster.Caregiver2_ID')
            ->leftJoin('users as cg3', 'cg3.UserID', '=', 'roster.Caregiver3_ID')
            ->leftJoin('users as cg4', 'cg4.UserID', '=', 'roster.Caregiver4_ID')
            ->where('roster.Date', $date)
            ->select(
                'roster.*',
                DB::raw("sup.First_Name || ' ' || sup.Last_Name AS SupervisorName"),
                DB::raw("doc.First_Name || ' ' || doc.Last_Name AS DoctorName"),
                DB::raw("cg1.First_Name || ' ' || cg1.Last_Name AS CG1Name"),
                DB::raw("cg2.First_Name || ' ' || cg2.Last_Name AS CG2Name"),
                DB::raw("cg3.First_Name || ' ' || cg3.Last_Name AS CG3Name"),
                DB::raw("cg4.First_Name || ' ' || cg4.Last_Name AS CG4Name")
            )
            ->first();

        return view('Roster', [
            'date'   => $date,
            'roster' => $roster,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
