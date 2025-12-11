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
            max-width: 650px;
            margin: 20px auto;
            background: white;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0px 0px 8px rgba(0,0,0,0.12);
        }


        h1 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 8px 0 4px 0;
            font-size: 14px;
        }

        select, input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #2f6fed;
            color: white;
            font-size: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
        }

        .row {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .left { width: 70%; }
        .right { width: 30%; }

        .multiselect {
            width: 100%;
            height: 70px;
            font-size: 12px;
        }

    </style>
</head>
<body>

<div class="page-container">
    <h1>Create New Roster</h1>

    <form action="{{ route('newRoster.store') }}" method="POST">
        @csrf

        <label>Roster Date</label>
        <input type="date" name="date" required>

        <label>Supervisor</label>
        <select name="supervisor_id" required>
            <option value="">Select Supervisor</option>
            @foreach ($supervisors as $s)
                <option value="{{ $s->UserID }}">{{ $s->First_Name }} {{ $s->Last_Name }}</option>
            @endforeach
        </select>

        <label>Doctor</label>
        <select name="doctor_id" required>
            <option value="">Select Doctor</option>
            @foreach ($doctors as $d)
                <option value="{{ $d->UserID }}">{{ $d->First_Name }} {{ $d->Last_Name }}</option>
            @endforeach
        </select>
       
        @for ($i = 1; $i <= 4; $i++)
            <label style="margin-top:20px;">Caregiver {{ $i }}</label>
            <div class="row">
                <div class="left">
                    <select name="cg{{ $i }}_id" id="cg{{ $i }}" onchange="loadGroups({{ $i }})">
                        <option value="">Select Caregiver</option>
                        @foreach ($caregivers as $c)
                            <option value="{{ $c->UserID }}">{{ $c->First_Name }} {{ $c->Last_Name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="right">
                    <select name="cg{{ $i }}_group[]" id="cg{{ $i }}_groups" class="multiselect" multiple>
                        @foreach ($groups as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endfor

        <button type="submit">Create Roster</button>
    </form>
</div>
<script>
    const caregiverGroups = @json($cgGroups);

    function loadGroups(num) {
        const cgId = document.getElementById(`cg${num}`).value;
        const groupSelect = document.getElementById(`cg${num}_groups`);

        [...groupSelect.options].forEach(o => o.selected = false);

        if (!cgId || !caregiverGroups[cgId]) return;

        caregiverGroups[cgId].forEach(g => {
            [...groupSelect.options].forEach(o => {
                if (o.value === g) {
                    o.selected = true;
                }
            });
        });
    }
</script>
</body>
</html>
