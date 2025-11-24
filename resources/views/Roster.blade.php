<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roster</title>
</head>
<body>
    <form method="GET" action="{{ route('roster.index') }}">
    <input type="date" name="date" value="{{ $date }}">
    <button type="submit">Search</button>
    </form>

    @if ($roster)
    <table>
        <tr><th>Role</th><th>Name</th></tr>

        <tr><td>Supervisor</td><td>{{ $roster->supervisor->First_Name }} {{ $roster->supervisor->Last_Name }}</td></tr>
        <tr><td>Doctor</td><td>{{ $roster->doctor->First_Name }} {{ $roster->doctor->Last_Name }}</td></tr>

        <tr><td>Caregiver 1</td><td>{{ $roster->cg1->First_Name }} {{ $roster->cg1->Last_Name }}</td></tr>
        <tr><td>Caregiver 2</td><td>{{ $roster->cg2->First_Name }} {{ $roster->cg2->Last_Name }}</td></tr>
        <tr><td>Caregiver 3</td><td>{{ $roster->cg3->First_Name }} {{ $roster->cg3->Last_Name }}</td></tr>
        <tr><td>Caregiver 4</td><td>{{ $roster->cg4->First_Name }} {{ $roster->cg4->Last_Name }}</td></tr>
    </table>
    @endif

</body>
</html>