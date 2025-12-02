<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Authentication_controller extends Controller
{
    // Show login page
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
{
    $request->validate([
        'Email' => 'required|email',
        'Password' => 'required'
    ]);

    $user = Users::where('Email', $request->Email)->first();

    if (!$user || !Hash::check($request->Password, $user->Password)) {
        return back()->withErrors(['Invalid email or password']);
    }

    // Save session
    session([
        'userid' => $user->UserID,
        'roleid' => $user->RoleID,
        'firstname' => $user->First_Name
    ]);

    // Role-based redirects
    switch ($user->RoleID) {
        case 1: return redirect('/admin/dashboard');
        case 2: return redirect('/doctor/home');
        case 3: return redirect('/patient_home');
        case 4: return redirect('/caregiver/home');
        case 5: return redirect('/family/home');
        default: return redirect('/');
    }
}


    // Role-based redirect
    private function redirectBasedOnRole($roleId)
    {
        switch ($roleId) {
            case 1:
                return redirect('/admin_home');
            case 2:
                return redirect('/doctor_home');
            case 3:
                return redirect('/patient_home');
            case 4:
                return redirect('/caregiver_home');
            case 5:
                return redirect('/family_home');
            default:
                return redirect('/');
        }
    }

public function showRegisterForm()
{
    return view('register');
}
    public function register(Request $request)
{
    $validated = $request->validate([
        'First_Name' => 'required',
        'Last_Name' => 'required',
        'Email' => 'required|email|unique:users,Email',
        'Phone' => 'required',
        'Password' => 'required|min(4)',
        'RoleID' => 'required|integer'
    ]);

    $user = new Users();

    $user->RoleID = $request->RoleID;
    $user->First_Name = $request->First_Name;
    $user->Last_Name = $request->Last_Name;
    $user->Email = $request->Email;
    $user->Phone = $request->Phone;
    $user->Password = Hash::make($request->Password);

    $user->Date_of_Birth = $request->Date_of_Birth;
    $user->Family_Code = $request->Family_Code;
    $user->Emergency_Contact = $request->Emergency_Contact;
    $user->Emergency_Contact_Relation = $request->Emergency_Contact_Relation;

    // default approved = 0 unless admin approves
    $user->Approved = 0;

    $user->save();

    return redirect('/login')->with('success', 'Account created! Wait for admin approval.');
}
    // Logout
    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    // Admin-only user approval page
    public function adminUserView()
    {
        // Retrieve all unapproved users
        $pendingUsers = DB::table('users')->where('Approved', 0)->get();

        // Placeholder for now
        return view('AdminUsers', ['pendingUsers' => $pendingUsers]);
    }



    public function approveUser($id)
    {
    DB::table('users')->where('UserID', $id)->update(['Approved' => 1]);

    return back()->with('success', 'User has been approved!');
    }

    public function deleteUser($id)
    {
    DB::table('users')->where('UserID', $id)->delete();

    return back()->with('success', 'User removed.');
    }

}


