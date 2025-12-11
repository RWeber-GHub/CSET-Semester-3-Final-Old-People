<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorController extends Controller
{
    // ====================================
    // DOCTOR HOME PAGE
    // ====================================
    public function index()
    {
        $doctorID = session('userid');

        $doctor = DB::table('users')->where('UserID', $doctorID)->first();
        if (!$doctor) {
            return redirect('/')->with('error', 'Doctor not found');
        }

        if (!$doctorID) {
            return redirect('/')->with('error', 'Not logged in.');
        }

        $today = Carbon::today()->toDateString();

       $appointmentsToday = DB::table('appointments')
            ->join('patients', 'appointments.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('appointments.DoctorID', $doctorID)
            ->whereDate('appointments.Date', $today)
            ->select(
                'appointments.AppointmentID',
                'appointments.PatientID',
                'users.First_Name',
                'users.Last_Name'
            )
            ->get();

        $todayActivity = DB::table('patient_home_activity')
            ->whereIn('PatientID', $appointmentsToday->pluck('PatientID'))
            ->whereDate('Date', $today)
            ->get()
            ->groupBy('PatientID');

        $oldAppointments = DB::table('appointments')
            ->join('patients', 'appointments.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('appointments.DoctorID', $doctorID)
            ->where('appointments.Date', '<', Carbon::now())
            ->orderBy('appointments.Date', 'desc')
            ->select('appointments.*', 'users.First_Name', 'users.Last_Name')
            ->get();

        $upcomingAppointments = DB::table('appointments')
            ->join('patients', 'appointments.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('appointments.DoctorID', $doctorID)
            ->where('appointments.Date', '>=', Carbon::now())
            ->orderBy('appointments.Date', 'asc')
            ->select('appointments.*', 'users.First_Name', 'users.Last_Name')
            ->get();

        $prescriptions = DB::table('prescriptions')
            ->join('patients', 'prescriptions.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->whereIn('prescriptions.PatientID', $appointmentsToday->pluck('PatientID'))
            ->select('prescriptions.*', 'users.First_Name', 'users.Last_Name')
            ->get();

        return view('Doctors_home', [
            'appointmentsToday' => $appointmentsToday,
            'todayActivity' => $todayActivity,
            'oldAppointments' => $oldAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'prescriptions' => $prescriptions,
            'doctor' => $doctor
        ]);
    }

    // ====================================
    // FILTER APPOINTMENTS
    // ====================================
    public function filterAppointments(Request $request)
    {
        $doctorID = session('userid');
        $now = Carbon::now();

        // Base query
        $query = DB::table('appointments')
            ->join('patients', 'appointments.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('appointments.DoctorID', $doctorID)
            ->select('appointments.*', 'users.First_Name', 'users.Last_Name');

        // Patient filter
        if ($request->patientID && $request->patientID !== "all") {
            $query->where('patients.PatientID', $request->patientID);
        }

        // Date filter
        if ($request->date) {
            $query->whereDate('appointments.Date', $request->date);
        }

        // Type filter
        if ($request->type === "past") {
            $query->where('appointments.Date', '<', $now);
        } elseif ($request->type === "upcoming") {
            $query->where('appointments.Date', '>=', $now);
        }

        // Get results
        $filtered = $query->orderBy('appointments.Date', 'asc')->get();

        // Split
        $oldAppointments = $filtered->where('Date', '<', $now);
        $upcomingAppointments = $filtered->where('Date', '>=', $now);

        // Load patients again
        $patients = DB::table('patients')
            ->join('appointments', 'appointments.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('appointments.DoctorID', $doctorID)
            ->select('patients.PatientID', 'users.First_Name', 'users.Last_Name')
            ->groupBy('patients.PatientID')
            ->get();

        // Patient home activity
        $patientRecords = DB::table('patient_home_activity')
            ->join('patients', 'patient_home_activity.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->select('patient_home_activity.*', 'users.First_Name', 'users.Last_Name')
            ->whereIn('patient_home_activity.PatientID', $patients->pluck('PatientID'))
            ->get();

        return view('Doctors_home', [
            'patients' => $patients,
            'patientRecords' => $patientRecords,
            'oldAppointments' => $oldAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'filters' => $request->all()
        ]);
    }

    // ====================================
    // VIEW PATIENT DETAIL PAGE
    // ====================================
    public function viewPatient($patientID)
    {
        $doctorID = session('userid');
        if (!$doctorID) return redirect('/');

        $patient = DB::table('patients')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->where('patients.PatientID', $patientID)
            ->select('patients.*', 'users.First_Name', 'users.Last_Name')
            ->first();

        if (!$patient) abort(404);

        $oldPrescriptions = DB::table('prescriptions')
            ->where('PatientID', $patientID)
            ->orderBy('Date', 'desc')
            ->get();

        $today = Carbon::now()->toDateString();

        $appointmentToday = DB::table('appointments')
            ->where('DoctorID', $doctorID)
            ->where('PatientID', $patientID)
            ->whereDate('Date', $today)
            ->first();

        $canCreateNew = $appointmentToday ? true : false;

        return view('Patient_of_doctor', [
            'patient' => $patient,
            'oldPrescriptions' => $oldPrescriptions,
            'appointmentToday' => $appointmentToday,
            'canCreateNew' => $canCreateNew,
            'today' => $today
        ]);
    }

    public function createPrescription(Request $request)
    {
        $doctorId = session('userid');
        $request->validate([
            'patient_id' => 'required|integer',
            'appointment_id' => 'required|integer',
            'details' => 'nullable|string|max:255'
        ]);

        $today = now()->toDateString();

        $existing = DB::table('prescriptions')
            ->where('PatientID', $request->patient_id)
            ->where('DoctorID', $doctorId)
            ->where('AppointmentID', $request->appointment_id)
            ->whereDate('Date', $today)
            ->first();

        if ($existing) {
            DB::table('prescriptions')
                ->where('PrescriptionID', $existing->PrescriptionID)
                ->update([
                    'Prescription_Details' => $request->details,
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Prescription updated for today.');
        }

        DB::table('prescriptions')->insert([
            'DoctorID' => $doctorId,
            'PatientID' => $request->patient_id,
            'AppointmentID' => $request->appointment_id,
            'Date' => now(),
            'Prescription_Details' => $request->details,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Prescription created successfully.');
    }
}
