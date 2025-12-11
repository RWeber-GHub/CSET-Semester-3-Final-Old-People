<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver Home</title>

    <style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --bg: #eef2f5;
            --white: #ffffff;
        }

        body { margin: 0; background: var(--bg); font-family: Arial, sans-serif; }

        nav {
            background: var(--dark-blue);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo { color: var(--white); font-size: 1.8rem; font-weight: bold; }
        nav ul { display: flex; gap: 20px; list-style: none; margin: 0; padding: 0; }
        nav ul li a { color: var(--white); text-decoration: none; padding: 8px 14px; border-radius: 6px; }
        nav ul li a:hover { background: var(--light-blue); }

        .container {
            width: 95%;
            max-width: 1100px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #0002;
        }

        h1 { color: var(--dark-blue); text-align: center; margin-bottom: 20px; }

        .search-box {
            background: var(--tan);
            padding: 15px;
            border-radius: 10px;
            border: 2px solid var(--pale-green);
            margin-bottom: 25px;
        }

        .btn-green {
            background: var(--pale-green); padding: 10px 20px; color: white;
            border-radius: 6px; border: none; cursor: pointer; font-weight: bold;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background: var(--light-blue); color: white; }
        td { background: #fafafa; }
        tr:nth-child(even) td { background: #f0f4ff; }

        .save-btn {
            margin-top: 20px; background: var(--pale-green); padding: 12px 30px;
            color: white; border: none; border-radius: 6px; cursor: pointer;
            font-size: 1.2rem; font-weight: bold;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">APEX HealthCare – Caregiver</div>
    <ul>
        <li><a href="/roster">Roster</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</nav>

<div class="container">

    <h1>Caregiver: {{ $caregiver->First_Name.' '.$caregiver->Last_Name }}</h1>

    <!-- DATE SELECTOR -->
    <div class="search-box">
        <form method="GET" action="{{ route('caregiver.activity') }}">
            <label>Select Date:</label>
            <input type="date" name="date" value="{{ $date }}">
            <button class="btn-green">Search</button>
        </form>
    </div>

    @isset($error)
        <div class="no-data">{{ $error }}</div>
    @endisset

    @if(isset($patients))

    <form method="POST" action="{{ route('caregiver.updateActivity') }}">
        @csrf

        <table>
            <tr>
                <th>Patient Name</th>
                <th>Doctor</th>
                <th>Appointment</th>
                <th>Morning</th>
                <th>Afternoon</th>
                <th>Night</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>

            @foreach($patients as $patient)

                @php
                    $hasPrescription = in_array($patient->PatientID, $prescriptionsToday ?? []);
                @endphp

                @foreach($patient->activity as $activity)

                    <tr>
                        <input type="hidden" name="activities[]" value="{{ $activity->ActivityID }}">

                        <td>{{ $patient->user->First_Name }} {{ $patient->user->Last_Name }}</td>

                        <td>{{ $activity->doctor->First_Name }} {{ $activity->doctor->Last_Name }}</td>

                        <td>
                            <input type="checkbox"
                                name="Appointment[{{ $activity->ActivityID }}]"
                                {{ $activity->Appointment ? 'checked' : '' }}>
                        </td>

                        <td>
                            @if($hasPrescription)
                                <input type="checkbox"
                                    name="Morning_Meds[{{ $activity->ActivityID }}]"
                                    {{ $activity->Morning_Meds ? 'checked' : '' }}>
                            @else
                                <span style="color:red;font-weight:bold;">No Rx</span>
                            @endif
                        </td>

                        <td>
                            @if($hasPrescription)
                                <input type="checkbox"
                                    name="Afternoon_Meds[{{ $activity->ActivityID }}]"
                                    {{ $activity->Afternoon_Meds ? 'checked' : '' }}>
                            @else
                                <span style="color:red;font-weight:bold;">No Rx</span>
                            @endif
                        </td>

                        <td>
                            @if($hasPrescription)
                                <input type="checkbox"
                                    name="Nighttime_Meds[{{ $activity->ActivityID }}]"
                                    {{ $activity->Nighttime_Meds ? 'checked' : '' }}>
                            @else
                                <span style="color:red;font-weight:bold;">No Rx</span>
                            @endif
                        </td>

                        <td><input type="checkbox" name="Breakfast[{{ $activity->ActivityID }}]" {{ $activity->Breakfast ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="Lunch[{{ $activity->ActivityID }}]" {{ $activity->Lunch ? 'checked' : '' }}></td>
                        <td><input type="checkbox" name="Dinner[{{ $activity->ActivityID }}]" {{ $activity->Dinner ? 'checked' : '' }}></td>
                    </tr>

                @endforeach

            @endforeach
        </table>



        <button class="save-btn">Save All Changes</button>

    </form>

    @endif

</div>

</body>
</html>