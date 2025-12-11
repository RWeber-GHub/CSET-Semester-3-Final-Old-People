<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patients Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/towerhealth.css">
    <style>
        :root {
            --dark-blue: #003056;
            --light-blue: #5980BE;
            --green: #8DB750;
            --tan: #F8F1CE;
            --white: #FFFFFF;
            --gray: #E0E0E0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--white);
            color: var(--dark-blue);
            margin: 0;
            padding: 0;
        }
        a {
            text-decoration: none;
            color: var(--dark-blue);
        }
        .page-wrap {
            padding: 30px;
        }

        .container-box {
            width: 95%;
            max-width: 1A100px;
            margin: 30px auto;
            background: var(--white);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #0002;
        }

        /* SECTION TITLES */
        h1, h2, h3 {
            color: var(--dark-blue);
            font-weight: bold;
        }

        /* FORM */
        input[type="date"] {
            padding: 10px;
            border: 2px solid var(--light-blue);
            border-radius: 6px;
            width: 220px;
        }
        /* Site Navigation */
        .site-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 15px 30px;
        }

        .site-nav .brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .site-nav a {
            margin-left: 15px;
            color: var(--white);
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            padding: 8px 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-primary {
            background-color: var(--light-blue);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--dark-blue);
        }
        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background: var(--light-blue);
            color: white;
            text-align: center;
        }
        tr:nth-child(even) td {
            background: #f0f4ff;
        }

        .activity-box {
            margin-top: 40px;
            padding: 20px;
            background: var(--tan);
            border-radius: 10px;
            border: 2px solid var(--pale-green);
        }

        .progress {
            width: 100%;
            height: 22px;
            background: #dcdcdc;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .progress-bar {
            background: var(--pale-green);
            height: 100%;
            text-align: center;
            color: white;
            font-weight: bold;
            line-height: 22px;
        }
        .details-row {
            display: flex;
            gap: 20px;
            width: 100%;
            max-width: 1100px;
            margin: 15px auto;
        }

        .half-box {
            width: 50%;
        }
            
        @media (max-width: 768px) {
            .details-row {
                flex-direction: column;
            }
            .half-box {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <div class="site-nav">
        <div class="brand">APEX HealthCare</div>
        <div>
            <a href="/">Home</a>
            <a href="/roster">Roster</a>
            <a href="/logout" class="btn btn-primary">Logout</a>
            
        </div>
    </div>
    <div class="page-wrap">
        <div class="details-row">
            <div class="container-box half-box">
                <h2>Patient ID: {{ $patient->PatientID }}</h2>
            </div>

            <div class="container-box half-box">
                <h2>Patient Name: {{ $user->First_Name.' '.$user->Last_Name }}</h2>
            </div>
        </div>



        <div class="container-box">
            <h3>Select Date</h3>
            <form method="GET" action="{{ route('patient.activity', $patient->PatientID) }}">
                <input type="date" name="date" value="{{ $date }}">
                <button type="submit" class="btn-important">Search</button>
            </form>
        

        <div class="activity-box container-box">

            @if ($patient_home_activity)
                <h3>Activities for {{ date('Y-m-d', strtotime($date)) }}</h3>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                        style="width: {{ $percent }}%;">
                        {{ $percent }}%
                    </div>
                </div>

                <table>
                    <tr>
                        <th>Doctor</th>
                        <th>Appointment</th>
                        <th>Caregiver</th>
                        <th>Morning Meds</th>
                        <th>Afternoon Meds</th>
                        <th>Night Meds</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                    </tr>

                    <tr>
                        <td>{{ $patient_home_activity->doctor->First_Name }} {{ $patient_home_activity->doctor->Last_Name }}</td>
                        <td>{{ $patient_home_activity->Appointment ? '✔️' : '❌' }}</td>
                        <td>{{ $patient_home_activity->caregiver->First_Name }} {{ $patient_home_activity->caregiver->Last_Name }}</td>
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

        </div>
        </div>
    </div>
</body>
</html>