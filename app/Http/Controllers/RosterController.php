<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roster;
use Carbon\Carbon;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $date = $request->query('date', Carbon::today()->toDateString());

    $roster = Roster::query()
        ->whereDate('date', $date)
        ->with(['supervisor','doctor','cg1','cg2','cg3','cg4'])
        ->first();

    return view('Roster', [
        'date' => $date,
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
