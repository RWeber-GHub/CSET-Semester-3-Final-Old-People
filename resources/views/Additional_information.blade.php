<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Additional Information of Patient</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f5;
            margin: 0;
            padding: 0;
        }

        .container {
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

        input {
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

        .row {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        .half {
            width: 50%;
        }

        .btn-area {
            display: flex;
            gap: 20px;
            margin-top: 25px;
        }

        .cancel {
            background: #b33;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Additional Information of Patient</h1>

    <form action="{{ route('patient.info.save') }}" method="POST">
        @csrf

        <div class="row">
            <div class="half">
                <label>Patient ID</label>
                <input type="number" id="patient_id" name="patient_id" required>
            </div>

            <div class="half">
                <label>Patient Name</label>
                <input type="text" id="patient_name" readonly style="background:#e0e0e0;">
                <small>Auto-fills</small>
            </div>
        </div>

        <label>Group (comma separated)</label>
        <input type="text" name="group">

        <label>Account Created At</label>
        <input type="text" id="created_at" readonly style="background:#e0e0e0;">


        <div class="btn-area">
            <button type="submit">OK</button>

            <a href="/admin_home" style="flex:1;">
                <button type="button" class="cancel">Cancel</button>
            </a>
        </div>

    </form>
</div>

<script>
    document.getElementById('patient_id').addEventListener('change', function () {
        let id = this.value;

        fetch('/ajax/patient-name/' + id)
            .then(res => res.json())
            .then(data => {
                document.getElementById('patient_name').value = data.name ?? "Not found";
                document.getElementById('created_at').value = data.created_at ?? "Not found";
                if (data.group){
                    document.querySelector('input[name="group"]').value =
                        Array.isArray(data.group) ? data.group.join(', ') : data.group;
                } else {
                    document.querySelector('input[name="group"]').value = "";
                }

            })
        .catch(err => console.error(err));
    });
</script>

</body>
</html>
