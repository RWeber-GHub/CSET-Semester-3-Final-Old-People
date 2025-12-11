    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor's Home</title>

        <style>
            :root {
                --dark-blue: #003056;
                --pale-green: #8DB750;
                --light-blue: #5980BE;
                --tan: #F8F1CE;
                --bg: #eef2f5;
                --white: #ffffff;
            }

            body {
                margin: 0;
                background: var(--bg);
                font-family: Arial, sans-serif;
            }

            .container {
                width: 95%;
                max-width: 1100px;
                margin: 30px auto;
                background: #fff;
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 0 10px #0002;
            }

            .btn-important {
                background: var(--pale-green);
                color: var(--white) !important;
                padding: 8px 15px;
                border-radius: 6px;
            }
            .btn-important:hover {
                opacity: 0.85;
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
            
            h1 {
                color: var(--dark-blue);
                text-align: center;
                margin-bottom: 25px;
            }

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

            td {
                background: #fafafa;
            }

            tr:nth-child(even) td {
                background: #f0f4ff;
            }

            .search-row input {
                width: 100%;
                padding: 6px;
                border: 1px solid #bbb;
                border-radius: 4px;
            }

            .btn-small {
                padding: 6px 12px;
                background: var(--pale-green);
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
            }

            .appointments-box {
                margin-top: 40px;
                padding: 20px;
                background: var(--tan);
                border-radius: 10px;
                border: 2px solid var(--pale-green);
            }

            .appointments-row {
                display: flex;
                gap: 15px;
                margin-bottom: 15px;
            }

            .appointments-row input {
                padding: 10px;
                border: 2px solid var(--light-blue);
                border-radius: 6px;
                width: 200px;
            }

            .btn-blue {
                background: var(--light-blue);
                color: white;
                padding: 12px 20px;
                border-radius: 6px;
                border: none;
                font-weight: bold;
                cursor: pointer;
            }

            .btn-green {
                background: var(--pale-green);
                color: white;
                padding: 12px 20px;
                border-radius: 6px;
                border: none;
                font-weight: bold;
                cursor: pointer;
            }

            .section-title {
                font-size: 20px;
                font-weight: bold;
                color: var(--dark-blue);
                margin: 15px 0 5px;
            }

            .appointment-table {
                width: 100%;
                margin-top: 10px;
                border-collapse: collapse;
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
    <div class="container">

        <h1>Welcome Dr. {{ $doctor->First_Name }} {{ $doctor->Last_Name }}</h1>

    <!-- ================================
         TODAY'S PATIENT ACTIVITY + RX
    ================================= -->
    <div class="section-title">Today's Patient Activity</div>

    <table>
        <tr>
            <th>Patient</th>
            <th>Activity Summary</th>
            <th>Prescription</th>
        </tr>

        @forelse($appointmentsToday as $appt)

        @php
            $a = $todayActivity[$appt->PatientID]->first() ?? null;
        @endphp

        <tr>
            <!-- PATIENT NAME -->
            <td>{{ $appt->First_Name }} {{ $appt->Last_Name }}</td>

            <!-- ACTIVITY -->
            <td>
                @if($a)
                    <strong>Appointment:</strong> {{ $a->Appointment ? '✔' : '✘' }} <br>
                    <strong>Morning Meds:</strong> {{ $a->Morning_Meds ? '✔' : '✘' }} <br>
                    <strong>Afternoon Meds:</strong> {{ $a->Afternoon_Meds ? '✔' : '✘' }} <br>
                    <strong>Night Meds:</strong> {{ $a->Nighttime_Meds ? '✔' : '✘' }} <br>
                    <strong>Meals:</strong>
                        B: {{ $a->Breakfast ? '✔' : '✘' }},
                        L: {{ $a->Lunch ? '✔' : '✘' }},
                        D: {{ $a->Dinner ? '✔' : '✘' }}
                @else
                    <span style="color:red;">No activity logged today</span>
                @endif
            </td>

            <!-- PRESCRIPTION BOX -->
            <td>
                <form method="POST" action="{{ route('doctor.createPrescription') }}">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $appt->PatientID }}">
                    <input type="hidden" name="appointment_id" value="{{ $appt->AppointmentID }}">

                    <textarea name="details" placeholder="Prescription notes..."
                              style="width:100%;height:70px;"></textarea><br>

                    <button class="btn-small">Add Prescription</button>
                </form>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="3" style="text-align:center;">No appointments today.</td>
        </tr>
        @endforelse
    </table>

        <!-- APPOINTMENTS SECTION -->
        <div class="appointments-box">
            <div class="appointments-row">
                <a href="{{ route('doctor.appointments') }}">
                    <button class="btn-blue">All Appointments</button>
                </a>

                <form method="POST" action="{{ route('doctor.filterAppointments') }}" style="display:flex; gap:15px;">
                    @csrf
                    <input type="date" name="till_date" required>
                    <button type="submit" class="btn-green">Filter</button>
                </form>
            </div>

            <div class="section-title">Old Appointments</div>
            <table class="appointment-table">
                <tr>
                    <th>Patient Name</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                </tr>
                @forelse($oldAppointments as $appt)
                    <tr>
                        <td>{{ $appt->First_Name }} {{ $appt->Last_Name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appt->Date)->format('Y-m-d H:i') }}</td>
                        <td>{{ $appt->Status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">No past appointments.</td>
                    </tr>
                @endforelse
            </table>

            <div class="section-title">Upcoming Appointments</div>
            <table class="appointment-table">
                <tr>
                    <th>Patient Name</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                </tr>
                @forelse($upcomingAppointments as $appt)
                    <tr>
                        <td>{{ $appt->First_Name }} {{ $appt->Last_Name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appt->Date)->format('Y-m-d H:i') }}</td>
                        <td>{{ $appt->Status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">No upcoming appointments.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </body>
    </html>