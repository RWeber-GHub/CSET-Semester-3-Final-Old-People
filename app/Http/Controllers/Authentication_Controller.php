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
        
        // Role-based redirects
        switch ((int)$user->RoleID) {
            case 1: return redirect('/admin_home');
            case 2: return redirect('/doctor_home');
            case 3: return redirect('/patient_home');
            case 4: return redirect('/caregiver_home');
            case 5: return redirect('/family_home');
            case 6: return redirect('/roster');
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
            $familyCode = $data['family_code_family'] ?? $data['family_code'] ?? null;
        } else {
            $familyCode = $data['family_code'] ?? null;
        }

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
        $user->Approved = 0;
        $user->User_Group = $familyCode ?? null;
        $user->save();

        if (in_array((int)$data['roleid'], [1,2,4,6,7])) {
            DB::table('employees')->insert([
                'UserID'    => $user->UserID,
                'Salary'    => 0.00,
                'Role'      => match((int)$data['roleid']) {
                    1 => 'Admin',
                    2 => 'Doctor',
                    4 => 'Caregiver',
                    6 => 'Supervisor',
                    7 => 'Employee',
                    default => 'Staff'
                },
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if ((int)$data['roleid'] === 3) {
            DB::table('patients')->insert([
                'UserID'         => $user->UserID,
                'Admission_Date' => now(),
                'Family_Code'     => $familyCode,
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
            return view('admin_home', [
        'pendingUsers' => DB::table('users')->where('Approved', 0)->get(),
        'allUsers' => null, // nothing until user searches
        'roles' => DB::table('roles')->get()
    ]);
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

    // ADMIN — User Search / Filters
    public function adminUserSearch(Request $request)
    {
        $roles = DB::table('roles')->get();

        $query = DB::table('users')
            ->leftJoin('roles', 'users.RoleID', '=', 'roles.RoleID')
            ->select('users.*', 'roles.Role_Name');

        if ($request->filled('userid')) {
            $query->where('users.UserID', $request->userid);
        }

        if ($request->filled('name')) {
            $query->where(function($q) use ($request) {
                $q->where('users.First_Name', 'LIKE', "%{$request->name}%")
                  ->orWhere('users.Last_Name', 'LIKE', "%{$request->name}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('users.RoleID', $request->role);
        }

        $allUsers = $query->get();

        return view('admin_home', [
            'pendingUsers' => DB::table('users')->where('Approved', 0)->get(),
            'allUsers' => $allUsers,
            'roles' => $roles,
        ]);
    }
    public function adminPatientActivity()
    {
        $records = DB::table('patient_home_activity')
            ->join('patients', 'patient_home_activity.PatientID', '=', 'patients.PatientID')
            ->join('users as p', 'patients.UserID', '=', 'p.UserID')
            ->leftJoin('users as c', 'patient_home_activity.CaregiverID', '=', 'c.UserID')
            ->leftJoin('users as d', 'patient_home_activity.DoctorID', '=', 'd.UserID')
            ->select(
                'patient_home_activity.*',
                'p.First_Name as PatientFirst',
                'p.Last_Name as PatientLast',
                'c.First_Name as CareFirst',
                'c.Last_Name as CareLast',
                'd.First_Name as DocFirst',
                'd.Last_Name as DocLast'
            )
            ->orderBy('ActivityID', 'desc')
            ->limit(25)
            ->get();

        return view('admin_patient_activity', [
            'records' => $records,
            'filters' => []
        ]);
    }

    public function adminPatientActivitySearch(Request $request)
    {
        $name = $request->name;
        $date = $request->date;
        $doctor = $request->doctor;
        $caregiver = $request->caregiver;

        $query = DB::table('patient_home_activity')
            ->join('patients', 'patient_home_activity.PatientID', '=', 'patients.PatientID')
            ->join('users as p', 'patients.UserID', '=', 'p.UserID')
            ->leftJoin('users as c', 'patient_home_activity.CaregiverID', '=', 'c.UserID')
            ->leftJoin('users as d', 'patient_home_activity.DoctorID', '=', 'd.UserID')
            ->select(
                'patient_home_activity.*',
                'p.First_Name as PatientFirst',
                'p.Last_Name as PatientLast',
                'c.First_Name as CareFirst',
                'c.Last_Name as CareLast',
                'd.First_Name as DocFirst',
                'd.Last_Name as DocLast'
            );

        if ($name) {
            $query->whereRaw("(p.First_Name || ' ' || p.Last_Name) LIKE ?", ["%$name%"]);
        }

        if ($date) {
            $query->whereDate('patient_home_activity.created_at', $date);
        }

        if ($doctor) {
            $query->whereRaw("(d.First_Name || ' ' || d.Last_Name) LIKE ?", ["%$doctor%"]);
        }

        if ($caregiver) {
            $query->whereRaw("(c.First_Name || ' ' || c.Last_Name) LIKE ?", ["%$caregiver%"]);
        }

        $records = $query->orderBy('ActivityID', 'desc')->get();

        return view('admin_patient_activity', [
            'records' => $records,
            'filters' => $request->all()
        ]);
}
}
