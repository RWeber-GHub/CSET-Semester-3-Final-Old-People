<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patients Home</title>
    <style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --background: #ffffff;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--background);
        }

        .btn-important {
            background: var(--pale-green);
            color: #fff !important;
        }

        /* FORM CONTAINER */
        .form-container {
            width: 900px;
            margin: 50px auto;
            background: var(--tan);
            padding: 30px;
            border-radius: 10px;
            border: 3px solid var(--pale-green);
        }
        h1, h2 {
            color: var(--dark-blue);
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 2px solid var(--light-blue);
            border-radius: 6px;
        }
        .btn {
            padding: 12px 30px;
            font-size: 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        
    </style>
</head>
<body>
    <h1>Patient ID: {{ $patient->PatientID }}</h1>
    <!-- get name from user? -->
    <h2>{{ $patient->Name }}</h2>
    <form action="{{ route('patient.prescription', $patient->PatientID) }}" class="form-container">
        <input type="submit" value="Date" class="btn">
        <input type="text" placeholder="{{ $date }}" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">
    </form>

    <h3>Prescription</h3>
    @if($prescription)
        <p><strong>Prescription Details:</strong></p>
        <p>{{ $prescription->Prescription_Details }}</p>
    @else
        <p>No prescription found</p>
    @endif
    @isset($patient_home_activity)
        <h3>Activities</h3>
    <table>
        <tr>
            <td>Doctor ID</td>
            <td>Appointment</td>
            <td>Caregiver ID</td>
            <td>Morning Meds</td>
            <td>Afternoon Meds</td>
            <td>Nighttime Meds</td>
            <td>Breakfast</td>
            <td>Lunch</td>
            <td>Dinner</td>
        </tr>
        <tr>
            <td>{{ $patient_home_activity->DoctorsID }}</td>
            <td>{{ $patient_home_activity->Appointment }}</td>
            <td>{{ $patient_home_activity->CaregiverID }}</td>
            <td>{{ $patient_home_activity->Morning_Meds }}</td>
            <td>{{ $patient_home_activity->Afternoon_Meds }}</td>
            <td>{{ $patient_home_activity->Nighttime_Meds }}</td>
            <td>{{ $patient_home_activity->Breakfast }}</td>
            <td>{{ $patient_home_activity->Lunch }}</td>
            <td>{{ $patient_home_activity->Dinner }}</td>
        </tr>
    </table>
    @endisset
</body>
</html>