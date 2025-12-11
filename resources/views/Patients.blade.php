<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients</title>
</head>
<body>
    <div id="patient_search">
        <form action="/login" method='post'>
            @csrf
            ID: <input type="text" name='id'><br>
            Name: <input type="text" name='name'><br>
            Age: <input type="text" name='age'><br>
            Emergency Contact: <input type="text" name='e_contact'><br>
            Emergency Contact Name: <input type="text" name='e_contact_num'><br>
            Admission Date: <input type="text" name='admission'><br>
            <input type="submit" value="Search">
        </form>
    </div>
</body>
</html>