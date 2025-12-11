<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patient Activity Viewer</title>

<style>
    /* Color Scheme */
            :root {
                --dark-blue: #003056;
                --light-blue: #5980BE;
                --green: #8DB750;
                --tan: #F8F1CE;
                --white: #FFFFFF;
                --gray: #E0E0E0;
            }

            /* General Styling */
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

            h1, h2, h3 {
                color: var(--dark-blue);
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
    h1 { color: var(--dark-blue); }
    .table-wrap {
        max-width: 90%;
        margin: 25px auto;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0,0,0,0.12);
        overflow-x: auto;
    }
    table {
        width: max-content;
        min-width: 900px;
    }
    th, td { padding:10px; border:1px solid #ccc; }
    th { background: var(--light-blue); color:white; }
    tr:nth-child(even) td { background:#f0f4ff; }
    input { padding:6px; width:200px; }
    .search-area { background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px #0002; }
    .btn { padding:10px 20px; border:none; background:var(--green); color:white; cursor:pointer; border-radius:6px; }
</style>
</head>

<body>
    <div class="site-nav">
        <div class="brand">APEX HealthCare</div>
        <div>
            <a href="/admin_home">Home</a>
            <a href="/patient-info">Add Patient Info</a>
            <a href="/appointments/create">Create Appointment</a>
            <a href="/roster">Roster</a>
            <a href="/employees">Employee Info</a>
            <a href="/logout" class="btn btn-primary">Logout</a>
            
        </div>
    </div>

    <h1>Patient Activity Records</h1>

    <div class="table-wrap">
        <div class="search-area">
        <form action="/admin/activity/search" method="GET">

            <input type="text" name="name" placeholder="Patient Name"
                value="{{ $filters['name'] ?? '' }}">

            <input type="date" name="date"
                value="{{ $filters['date'] ?? '' }}">

            <input type="text" name="doctor" placeholder="Doctor"
                value="{{ $filters['doctor'] ?? '' }}">

            <input type="text" name="caregiver" placeholder="Caregiver"
                value="{{ $filters['caregiver'] ?? '' }}">

            <button class="btn">Search</button>
        </form>
    </div>
    </div>
    

    <div class="table-wrap">
    <table>
        <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Caregiver</th>
            <th>Appointment</th>
            <th>Morning Meds</th>
            <th>Afternoon Meds</th>
            <th>Night Meds</th>
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
            <th>Date</th>
        </tr>

        @forelse($records as $r)
        <tr>
            <td>{{ $r->PatientFirst }} {{ $r->PatientLast }}</td>
            <td>{{ $r->DocFirst }} {{ $r->DocLast }}</td>
            <td>{{ $r->CareFirst }} {{ $r->CareLast }}</td>
            <td>{{ $r->Appointment ? 'Yes' : 'No' }}</td>
            <td>{{ $r->Morning_Meds ? '✔' : '—' }}</td>
            <td>{{ $r->Afternoon_Meds ? '✔' : '—' }}</td>
            <td>{{ $r->Nighttime_Meds ? '✔' : '—' }}</td>
            <td>{{ $r->Breakfast ? '✔' : '—' }}</td>
            <td>{{ $r->Lunch ? '✔' : '—' }}</td>
            <td>{{ $r->Dinner ? '✔' : '—' }}</td>
            <td>{{ $r->created_at }}</td>
        </tr>
        @empty
        <tr><td colspan="11" style="text-align:center;">No records found.</td></tr>
        @endforelse
    </table>
    </div>
</body>
</html>
