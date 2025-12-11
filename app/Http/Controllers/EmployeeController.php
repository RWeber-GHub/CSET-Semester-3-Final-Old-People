<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Dropdown Roles
        $roles = [
            1 => "Admin",
            2 => "Doctor",
            4 => "Caregiver",
            6 => "Supervisor"
        ];

        // Search filters
        $searchID = $request->input('id');
        $searchName = $request->input('name');
        $searchRole = $request->input('role');
        $searchSalary = $request->input('salary');

        $employees = DB::table('employees')
            ->join('users', 'employees.UserID', '=', 'users.UserID')
            ->select(
                'employees.EmployeeID',
                'employees.Role',
                'employees.Salary',
                'users.First_Name',
                'users.Last_Name'
            )
            ->when($searchID, function($q) use($searchID){
                return $q->where('EmployeeID', 'LIKE', "%$searchID%");
            })
            ->when($searchName, function($q) use($searchName){
                return $q->whereRaw("First_Name || ' ' || Last_Name LIKE ?", ["%$searchName%"]);
            })
            ->when($searchRole, function($q) use($searchRole){
                return $q->where('employees.Role', $searchRole);
            })
            ->when($searchSalary, function($q) use($searchSalary){
                return $q->where('employees.Salary', 'LIKE', "%$searchSalary%");
            })
            ->orderBy('EmployeeID')
            ->get();

        return view('employee_list', compact('employees', 'roles'));
    }

    public function updateSalary(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric',
            'new_salary' => 'required|numeric|min:0'
        ]);

        // Get logged user from session
        $userID = session('userid');

        $userRole = DB::table('employees')
            ->where('UserID', $userID)
            ->value('Role');

        if ($userRole !== "Admin") {
            return back()->with('error', 'Only Admin can change salaries.');
        }

        DB::table('employees')
            ->where('EmployeeID', $request->employee_id)
            ->update([
                'Salary' => $request->new_salary,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Salary updated successfully.');
    }
}