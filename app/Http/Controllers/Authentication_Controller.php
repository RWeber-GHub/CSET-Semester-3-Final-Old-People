<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Users::where('Email', $data['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with that email.']);
        }

        // Ensure account is approved
        if ((int)$user->Approved !== 1) {
            return back()->withErrors(['email' => 'Account not approved yet.']);
        }

        if (!Hash::check($data['password'], $user->Password)) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        // Save session values
        session([
            'userid' => $user->UserID,
            'roleid' => $user->RoleID,
            'firstname' => $user->First_Name,
            'email' => $user->Email
        ]);

        // Role-based redirects (placeholder paths)
        switch ((int)$user->RoleID) {
            case 1: return redirect('/admin_home');
            case 2: return redirect('/doctor_home');
            case 3: return redirect('/patient_home');
            case 4: return redirect('/caregiver_home');
            case 5: return redirect('/family_home');
            default: return redirect('/');
        }
    }

    // Show register page
    public function showRegisterForm()
    {
        return view('register');
    }

    // Handle register
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,Email',
            'phone'      => 'nullable|string|max:30',
            'password'   => 'required|string|min:4',
            'roleid'     => 'required|integer|in:1,2,3,4,5,6,7',
            'date_of_birth' => 'nullable|date',
            'family_code' => 'nullable|string|max:64',
            'family_code_family' => 'nullable|string|max:64',
            'emergency_contact' => 'nullable|string|max:64',
            'emergency_contact_relation' => 'nullable|string|max:64',
        ]);

        // If patient and no family_code provided, generate a family code
        $familyCode = null;
        if ((int)$data['roleid'] === 3) {
            $familyCode = $data['family_code'] ?? 'FAM' . rand(100, 999);
        } elseif ((int)$data['roleid'] === 5) {
            // family member: prefer the family_code_family field if provided
            $familyCode = $data['family_code_family'] ?? $data['family_code'] ?? null;
        } else {
            $familyCode = $data['family_code'] ?? null;
        }

        // Create user and map to DB columns
        $user = new Users();
        $user->RoleID = (int)$data['roleid'];
        $user->First_Name = $data['first_name'];
        $user->Last_Name = $data['last_name'];
        $user->Email = $data['email'];
        $user->Phone = $data['phone'] ?? null;
        $user->Password = Hash::make($data['password']);
        $user->Date_of_Birth = $data['date_of_birth'] ?? null;
        $user->Family_Code = $familyCode;
        $user->Emergency_Contact = $data['emergency_contact'] ?? null;
        $user->Emergency_Contact_Relation = $data['emergency_contact_relation'] ?? null;

        // default approved = 0 unless admin sets it
        $user->Approved = 0;

        // optional: set a User_Group; here we set same as Family_Code if present
        $user->User_Group = $familyCode ?? null;

        $user->save();
        
        // Create Patient if selected role is patient
        if ((int)$data['roleid'] === 3){
            DB::table('patients')->insert([
                'UserID'         => $user->UserID,
                'Admission_Date' => now(),
                'FamilyCode'     => $familyCode,
                'Relation'       => $user->Emergency_Contact_Relation,  
                'Amount_Due'     => 0,       
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }


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
    $pendingUsers = DB::table('users')->where('Approved', 0)->get();
    
    return view('admin_home', [
        'pendingUsers' => $pendingUsers
    ]);
}


    // Approve user
    public function approveUser($id)
    {
        DB::table('users')->where('UserID', $id)->update(['Approved' => 1]);
        return back()->with('success', 'User has been approved!');
    }

    // Delete/Reject user
    public function deleteUser($id)
    {
        DB::table('users')->where('UserID', $id)->delete();
        return back()->with('success', 'User removed.');
    }
}
