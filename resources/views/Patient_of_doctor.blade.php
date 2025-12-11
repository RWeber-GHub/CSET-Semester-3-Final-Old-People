<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient of Doctor</title>

    <style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --background: #ffffff;
            --white: #ffffff;
        }

        body { margin: 0; font-family: Arial, sans-serif; background: var(--background); }

        .btn-important { background: var(--pale-green); color: #fff !important; }

        nav {
            background: var(--dark-blue);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo {
            color: var(--white);
            font-size: 1.8rem;
            font-weight: bold;
        }
        nav ul {
            display: flex;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li a {
            text-decoration: none;
            color: var(--white);
            padding: 8px 14px;
            border-radius: 6px;
            transition: 0.3s;
        }
        nav ul li a:hover {
            background: var(--light-blue);
        }
        /* FORM CONTAINER */
        .form-container { width: 900px; margin: 50px auto; background: var(--tan); padding: 30px; border-radius: 10px; border: 3px solid var(--pale-green); }
        h1, h2 { color: var(--dark-blue); text-align: center; }
        input { width: 100%; padding: 10px; font-size: 1rem; border: 2px solid var(--light-blue); border-radius: 6px; }
        select { width: 100%; padding: 10px; font-size: 1rem; border: 2px solid var(--light-blue); border-radius: 6px; }
        .btn { padding: 12px 30px; font-size: 1rem; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; font-size: 14px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        table th { background-color: #4CAF50; color: white; font-weight: bold; }
        table tr:nth-child(even) { background-color: #f9f9f9; }
        table tr:hover { background-color: #f1f1f1; }
        table td { vertical-align: middle; }

        .action-row {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 30px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">APEX HealthCare</div>
        <ul>
            <li><a href="/roster" class="btn-important">Roster</a></li>
            <li><a href="/logout" class="btn-important">Logout</a></li>

        </ul>
    </nav>
    <h1>Patient of Doctor</h1>

    <h2>{{ $patient->First_Name }} {{ $patient->Last_Name }}</h2>
    <h3>{{ $today }}</h3>

    <h1>Past Perscriptions</h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Prescription Details</th>
        </tr>

        @forelse ($oldPrescriptions as $p)
        <tr>
            <td>{{ \Carbon\Carbon::parse($p->Date)->format('Y-m-d') }}</td>
            <td>{{ $p->Prescription_Details }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No previous prescriptions.</td>
        </tr>
        @endforelse
    </table>
    <table id="new">
        <tr>
            <th>Prescription Details</th>
        </tr>
    </table>

    @if($canCreateNew)
    <form method="POST" action="{{ route('doctor.createPrescription') }}">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->PatientID }}">
        <input type="hidden" name="appointment_id" value="{{ $appointmentToday->AppointmentID }}">

       
        <textarea name="details" rows="3" style="width:50%; margin-top: 20px;"></textarea>

        <div class="action-row">
            <button type="submit" class="btn" >New Prescription</button>
            <a href="/doctor_home">Cancel</a>
        </div>
    </form>
    @endif

</body>
</html>