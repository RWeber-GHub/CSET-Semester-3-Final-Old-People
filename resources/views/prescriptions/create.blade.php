<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Prescription</title>
  <link rel="stylesheet" href="{{ asset('css/towerhealth.css') }}">
</head>
<body>
<div class="site-nav">
  <div class="brand">TOWER HEALTH - Prescriptions</div>
  <div><a href="/admin_home" class="btn">Admin</a></div>
</div>

<div class="auth-wrap">
  <div class="auth-card" style="max-width:720px; margin:0 auto;">
    <h2>Add Prescription for Appointment #{{ $appointment->AppointmentID }}</h2>

    <div class="small-note">Patient: {{ $patient->First_Name }} {{ $patient->Last_Name }}</div>
    <div class="small-note">Doctor: {{ $doctor->First_Name }} {{ $doctor->Last_Name }}</div>

    @if($errors->any())
      <div class="alert error">
        <ul style="margin:0;padding-left:18px;">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('prescriptions.store', ['id' => $appointment->AppointmentID]) }}">
      @csrf

      <label>Prescription Details</label>
      <textarea name="prescription_details" rows="6" class="w-full p-2 border rounded" required></textarea>

      <label style="margin-top:10px;">Date (optional)</label>
      <input type="datetime-local" name="date">

      <div style="margin-top:12px;">
        <button class="btn btn-primary">Save Prescription</button>
        <a href="/admin_home" class="btn btn-secondary" style="margin-left:8px;">Done</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
