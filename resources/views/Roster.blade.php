<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APEX Roster</title>

    <style>
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

        /* PAGE CONTAINER */
        .page-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 25px;
            border-radius: 12px;
            background: var(--white);
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            color: var(--dark-blue);
            margin-bottom: 25px;
        }

        /* TABLE STYLING */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: var(--dark-blue);
            color: var(--white);
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border: 1px solid #ddd;
            background: var(--white);
        }

        tr:nth-child(even) td {
            background: var(--tan);
        }
        .btn-important {
            background: var(--green);
            color: var(--white) !important;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        .btn-important:hover {
            opacity: 0.85;
        }
        /* NO ROSTER MESSAGE */
        .no-roster {
            text-align: center;
            padding: 20px;
            color: var(--dark-blue);
            font-weight: bold;
        }

        /* BUTTONS */
        .back-btn {
            display: inline-block;
            margin: 25px auto 0;
            padding: 12px 20px;
            text-align: center;
            background: var(--pale-green);
            color: var(--white);
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }
        .back-btn:hover {
            background: var(--light-blue);
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            table, th, td {
                font-size: 0.9rem;
            }
            nav ul {
                flex-direction: column;
                gap: 10px;
            }
        }

        .cg-block {
            padding: 10px 0;
            border-bottom: 1px solid #dcdcdc;
        }

    </style>
</head>
<body>
    <div class="site-nav">
        <div class="brand">APEX HealthCare</div>

        <div>
            <a href="/">Website</a>
            @if(isset($RoleID))

                @switch($RoleID)
                    @case(1)
                        <a href="/admin_home" class="btn-important">Home</a>
                        @break
                    @case(2)
                        <a href="/doctor_home" class="btn-important">Home</a>
                        @break
                    @case(3)
                        <a href="/patient_home" class="btn-important">Home</a>
                        @break
                    @case(4)
                        <a href="/caregiver_home" class="btn-important">Home</a>
                        @break
                    @case(5)
                        <a href="/family_home" class="btn-important">Home</a>
                        @break
                    @case(6)
                        <a href="/roster" class="btn-important">Home</a>
                        @break
                @endswitch

                <a href="/logout" class="btn btn-primary">Logout</a>

            @else
                <a href="/login" class="btn-important">Login</a>
                <a href="/register">Register</a>
            @endif
        </div>
    </div>

    <!-- PAGE CONTENT -->
    <div class="page-container">
        <h1>Roster</h1>
        <form method="GET" action="/roster" style="margin-bottom: 25px; display:flex; gap:15px; align-items:center;">
            <input type="date" name="date" value="{{ $date }}" 
                style="padding: 10px; border: 2px solid var(--light-blue); border-radius: 6px;">

            <button type="submit" style="background: var(--green); color:white; padding:10px 18px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
                Search
            </button>
        </form>

        <h2>Roster for {{ $date }}</h2>

        @if(!$roster)
            <p>No roster found for this date.</p>
        @else

            <table>
                <tr>
                    <th>Supervisor</th>
                    <th>Doctor</th>
                    <th>Caregivers</th>
                    <th>Groups</th>
                </tr>

                <tr>
                    <td>
                        {{ $users[$roster->SupervisorID]->First_Name }}
                        {{ $users[$roster->SupervisorID]->Last_Name }}
                    </td>

                    <td>
                        {{ $users[$roster->DoctorID]->First_Name }}
                        {{ $users[$roster->DoctorID]->Last_Name }}
                    </td>

                    @php
                        $caregiversList = [
                            $roster->Caregiver1_ID,
                            $roster->Caregiver2_ID,
                            $roster->Caregiver3_ID,
                            $roster->Caregiver4_ID,
                        ];
                    @endphp

                    <td>
                        @foreach ($caregiversList as $cgId)
                            @if ($cgId)
                                <div class="cg-block">
                                    {{ $users[$cgId]->First_Name }} {{ $users[$cgId]->Last_Name }}
                                </div>
                            @endif
                        @endforeach
                    </td>

                    <td>
                        @foreach ($caregiversList as $cgId)
                            @if ($cgId)
                                @php
                                    $cgUser = $users[$cgId];
                                    $raw = $cgUser->User_Group;

                                    $groups = json_decode($raw, true);
                                    if (is_string($groups)) $groups = json_decode($groups, true);
                                    if (!is_array($groups)) $groups = $raw ? [trim($raw, "\"")] : [];
                                @endphp

                                <div class="cg-block">
                                    @if(count($groups))
                                        {{ implode(', ', $groups) }}
                                    @else
                                        <span style="color:#777;">No Groups</span>
                                    @endif
                                </div>

                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>

        @endif

        @if ($RoleID == 1 || $RoleID == 6)
            <div style="text-align:center; margin-top:25px;">
                <a href="/new-roster" class="btn-important">Create New Roster</a>
            </div>
        @endif

    </div>

</body>
</html>
