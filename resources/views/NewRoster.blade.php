<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Roster</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f5;
            margin: 0;
            padding: 0;
        }

        .page-container {
            width: 100%;
            max-width: 700px;
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

        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }

        select, input {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2f6fed;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background: #1c49c7;
        }
    </style>
</head>
<body>

<div class="page-container">
    <h1>Create New Roster</h1>

    <form action="{{ route('newRoster.store') }}" method="POST">
        @csrf

        <label for="date">Roster Date</label>
        <input type="date" name="date" required>

        <select name="supervisor_id">
            <option value="">-- Select Supervisor --</option>
            @foreach ($supervisors as $s)
                <option value="{{ $s->UserID }}">
                    {{ $s->First_Name }} {{ $s->Last_Name }}
                </option>
            @endforeach
        </select>



        <select name="doctor_id" required>
            <option value="">Select Doctor</option>
            @foreach($doctors as $d)
                <option value="{{ $d->UserID }}">
                    {{ $d->First_Name }} {{ $d->Last_Name }}
                </option>
            @endforeach
        </select>


        <select name="cg1_id" required>
            <option value="">Select Caregiver 1</option>
            @foreach($caregivers as $c)
                <option value="{{ $c->UserID }}">
                    {{ $c->First_Name }} {{ $c->Last_Name }}
                </option>
            @endforeach
        </select>


        <select name="cg2_id">
            <option value="">Select Caregiver 2</option>
            @foreach($caregivers as $c)
                <option value="{{ $c->UserID }}">
                    {{ $c->First_Name }} {{ $c->Last_Name }}
                </option>
            @endforeach
        </select>


        <select name="cg3_id">
            <option value="">Select Caregiver 3</option>
            @foreach($caregivers as $c)
                <option value="{{ $c->UserID }}">
                    {{ $c->First_Name }} {{ $c->Last_Name }}
                </option>
            @endforeach
        </select>

        
        <select name="cg4_id">
            <option value="">Select Caregiver 4</option>
            @foreach($caregivers as $c)
                <option value="{{ $c->UserID }}">
                    {{ $c->First_Name }} {{ $c->Last_Name }}
                </option>
            @endforeach
        </select>


        <button type="submit">Create Roster</button>

    </form>
</div>

</body>
</html>
