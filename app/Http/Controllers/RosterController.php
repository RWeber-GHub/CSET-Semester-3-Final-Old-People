<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roster;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $id = session('userid');
        if (!$id) {
            return redirect('/login');
        }
        $date = $request->date ?? Carbon::today()->toDateString();

        $user = Users::where('UserID', $id)->firstOrFail();
        $roster = DB::table('roster')
            ->whereDate('Date', $date)
            ->first();

        if (!$roster) {
            return view('Roster', [
                'date'   => $date,
                'roster' => null,
                'users'  => [],
                'user'   => $user,
                'RoleID' => $user->RoleID,
            ]);
        }
    
        $ids = [
            $roster->SupervisorID,
            $roster->DoctorID,
            $roster->Caregiver1_ID,
            $roster->Caregiver2_ID,
            $roster->Caregiver3_ID,
            $roster->Caregiver4_ID
        ];

        $users = DB::table('users')
            ->whereIn('UserID', $ids)
            ->get()
            ->keyBy('UserID');

        return view('Roster', [
            'date'   => $date,
            'roster' => $roster,
            'users'  => $users,
            'user'   => $user,
            'RoleID' => $user->RoleID,
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
