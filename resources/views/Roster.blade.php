<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roster</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f5;
            margin: 0;
            padding: 0;
        }

        .page-container {
            width: 95%;
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2f6fed;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            background: #fafafa;
            border: 1px solid #ccc;
        }

        tr:nth-child(even) td {
            background: #f0f4ff;
        }

        .back-btn {
            display: block;
            width: 200px;
            margin: 20px auto 0;
            padding: 12px;
            text-align: center;
            background: #2f6fed;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="page-container">

    <h1>Roster for {{ $date }}</h1>

    @if ($roster)
    <table>
        <tr>
            <th>Supervisor</th>
            <th>Doctor</th>
            <th>Caregivers</th>
        </tr>

        <tr>
            <td>{{ $roster->SupervisorName }}</td>
            <td>{{ $roster->DoctorName }}</td>
            <td>
                {{ $roster->CG1Name }}<br>
                {{ $roster->CG2Name }}<br>
                {{ $roster->CG3Name }}<br>
                {{ $roster->CG4Name }}
            </td>
        </tr>
    </table>
    @else
        <p style="text-align:center; padding:20px;">No roster found for this date.</p>
    @endif

    <a href="/new-roster" class="back-btn">Create New Roster</a>

</div>

</body>
</html>
