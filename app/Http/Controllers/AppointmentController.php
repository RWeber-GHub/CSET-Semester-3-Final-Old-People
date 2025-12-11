<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // Show create form
    public function createForm(Request $request)
    {
        // Access control: admin (1), doctor (2), supervisor (6)
        $role = session('roleid');
        if (!in_array((int)$role, [1,2,6])) {
            return redirect('/login')->withErrors('Unauthorized.');
        }

        // default date = today
        $today = date('Y-m-d');

        // fetch doctors on roster for today to seed the dropdown
        $doctors = $this->getDoctorsForDate($today);

        // patient lookup will be done via AJAX
        return view('appointments.create', [
            'doctors' => $doctors,
            'default_date' => $today,
            'role' => (int)$role
        ]);
    }

    // Store appointment
    public function store(Request $request)
    {
        $role = session('roleid');
        if (!in_array((int)$role, [1,6])) {
            return redirect('/login')->withErrors('Unauthorized.');
        }

        $data = $request->validate([
            'patient_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $exists = DB::table('patients')
                        ->where('PatientID', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('The selected patient does not exist.');
                    }
                }
            ],
            'doctor_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $doctor = DB::table('users')
                        ->where('UserID', $value)
                        ->where('RoleID', 2)
                        ->exists();

                    if (!$doctor) {
                        $fail('The selected doctor is not valid.');
                    }
                }
            ],
            'date'   => 'required|date',
            'status' => 'nullable|string|max:50'
        ]);

        $rosterRow = DB::table('roster')
            ->whereDate('Date', date('Y-m-d', strtotime($data['date'])))
            ->where('DoctorID', $data['doctor_id'])
            ->first();

        if (!$rosterRow) {
            return back()->withErrors([
                'doctor_id' => 'Selected doctor is not rostered for that date.'
            ])->withInput();
        }

        $appointmentId = DB::table('appointments')->insertGetId([
            'DoctorID'   => $data['doctor_id'],
            'PatientID'  => $data['patient_id'],
            'Date'       => date('Y-m-d H:i:s', strtotime($data['date'])),
            'Status'     => $data['status'] ?? 'Scheduled',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $activityDate = date('Y-m-d', strtotime($data['date']));

        $existing = DB::table('patient_home_activity')
            ->whereDate('Date', $activityDate)
            ->where('PatientID', $data['patient_id'])
            ->first();

        if ($existing) {
            DB::table('patient_home_activity')
                ->where('ActivityID', $existing->ActivityID)
                ->update([
                    'Appointment' => true,
                    'DoctorID'    => $data['doctor_id'],
                    'updated_at'  => now(),
                ]);
        } else {
            DB::table('patient_home_activity')->insert([
                'PatientID'      => $data['patient_id'],
                'DoctorID'       => $data['doctor_id'],
                'CaregiverID'    => null,
                'Date'           => $activityDate . ' 00:00:00',
                'Appointment'    => true,
                'Morning_Meds'   => false,
                'Afternoon_Meds' => false,
                'Nighttime_Meds' => false,
                'Breakfast'      => false,
                'Lunch'          => false,
                'Dinner'         => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        return redirect()->route('appointments.create')
            ->with('success', 'Appointment created successfully and activity updated!');

    }

    // AJAX endpoint: return patient name JSON
    public function ajaxPatientName($patientId)
    {
        $patient = DB::table('patients')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('patients.PatientID', (int)$patientId)
            ->select('users.First_Name', 'users.Last_Name')
            ->first();

        if (!$patient) {
            return response()->json(['found' => false], 404);
        }

        return response()->json([
            'found' => true,
            'full_name' => trim($patient->First_Name . ' ' . $patient->Last_Name)
        ]);
    }

    // AJAX endpoint: get doctors for a date or for today
    // Accepts ?date=YYYY-MM-DD
    public function ajaxDoctorsByDate(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));
        $doctors = $this->getDoctorsForDate($date);

        return response()->json(['doctors' => $doctors]);
    }

    // Helper: return array of doctors (UserID, First_Name, Last_Name)
    private function getDoctorsForDate($date)
    {
        // roster table links Date -> DoctorID; doctors are users with RoleID = 2
        $rows = DB::table('roster')
            ->whereDate('Date', $date)
            ->pluck('DoctorID')
            ->unique()
            ->toArray();

        if (empty($rows)) return [];

        $doctors = DB::table('users')
            ->select('UserID','First_Name','Last_Name')
            ->whereIn('UserID', $rows)
            ->where('RoleID', 2)
            ->get()
            ->map(function($d){
                return [
                    'id' => $d->UserID,
                    'name' => $d->First_Name . ' ' . $d->Last_Name
                ];
            })->values()->all();

        return $doctors;
    }
}
