<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Members Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --background: #ffffff;
            --white: #ffffff;   
        }
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

        body { margin: 0; font-family: Arial, sans-serif; background: var(--background); }

        .btn-important { background: var(--pale-green); color: #fff !important; }

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
    </style>
<body>
    <nav>
        <div class="logo">APEX HealthCare</div>
        <ul>
            <li><a href="/roster" class="btn-important">Roster</a></li>
            <li><a href="/logout" class="btn-important">Logout</a></li>
            <a class="nav-link text-danger" href="/logout">Logout</a>
        </ul>
    </nav>

    <h1>Family Member: {{ $family->First_Name.' '.$family->Last_Name }}</h1>

    <form method="GET" action="{{ route('family.home') }}" class="form-container">

        <label>Select Patient</label>
        <select name="patient"> 
            @foreach($patients as $p)
                <option value="{{ $p->PatientID }}" 
                    {{ request('patient') == $p->PatientID ? 'selected' : '' }}>
                    {{ $p->user->First_Name.' '.$p->user->Last_Name }}
                </option>
            @endforeach
        </select>
        <label>Select Date</label>
        <input type="date" name="date" value="{{ $date }}">
        <button type="submit" class="btn">Search</button>
    </form>

    @if($selectedPatient)
        <h3>Activities for {{ $selectedPatient->user->First_Name.' '.$selectedPatient->user->Last_Name }} on {{ $date }}</h3>

        @if($patient_home_activity)
            <table>
                <tr>
                    <th>Doctor Name</th>
                    <th>Appointment</th>
                    <th>Caregiver Name</th>
                    <th>Morning Meds</th>
                    <th>Afternoon Meds</th>
                    <th>Nighttime Meds</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
                <tr>
                    <td>{{ $patient_home_activity->doctor->First_Name.' '.$patient_home_activity->doctor->Last_Name }}</td>
                    <td>{{ $patient_home_activity->Appointment ? '✔️' : '❌' }}</td>
                    <td>{{ $patient_home_activity->caregiver->First_Name .' '. $patient_home_activity->caregiver->Last_Name }}</td>
                    <td>{{ $patient_home_activity->Morning_Meds ? '✔️' : '❌' }}</td>
                    <td>{{ $patient_home_activity->Afternoon_Meds ? '✔️' : '❌' }}</td>
                    <td>{{ $patient_home_activity->Nighttime_Meds ? '✔️' : '❌' }}</td>
                    <td>{{ $patient_home_activity->Breakfast ? '✔️' : '❌' }}</td>
                    <td>{{ $patient_home_activity->Lunch ? '✔️' : '❌' }}</td>
                    <td>{{ $patient_home_activity->Dinner ? '✔️' : '❌' }}</td>
                </tr>
            </table>
        @else
            <p style="text-align:center;">No activity found for this date.</p>
        @endif
    @endif
</body>
</html>