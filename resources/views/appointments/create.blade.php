<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Appointment</title>

    <style>
        /* ====== COLOR SCHEME ====== */
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --text-dark: #111;
            --text-light: #fff;
        }

        body {
            background: #fff;
            color: var(--text-dark);
            font-family: Arial, sans-serif;
            margin: 0;
        }

        /* ====== TOP NAV ====== */
        .site-nav {
            background: var(--dark-blue);
            color: var(--text-light);
            padding: 14px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .site-nav .brand {
            font-size: 1.3rem;
            font-weight: 600;
        }
        .site-nav a.btn {
            background: var(--light-blue);
            color: #fff;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
        }
        .site-nav a.btn:hover {
            background: var(--pale-green);
            color: var(--dark-blue);
        }

        /* ====== CARD WRAPPER ====== */
        .auth-wrap {
            padding: 40px;
        }

        .auth-card {
            background: #fff;
            border: 2px solid var(--pale-green);
            border-radius: 10px;
            padding: 28px 32px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }

        h2 {
            margin-top: 0;
            border-left: 6px solid var(--pale-green);
            padding-left: 12px;
        }

        /* ====== FORM ====== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-top: 20px;
        }
        .form-grid .full {
            grid-column: 1 / 3;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid var(--pale-green);
            border-radius: 6px;
            background: #fff;
            color: var(--text-dark);
        }
        input:focus, select:focus {
            border-color: var(--light-blue);
            outline: none;
        }

        .small-note {
            font-size: 0.85rem;
            color: #555;
            margin-top: 6px;
        }

        /* ====== ALERTS ====== */
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            border: 2px solid var(--pale-green);
            background: var(--tan);
        }
        .alert.error {
            border-color: #b94a48;
            color: #b94a48;
        }
        .alert.success {
            border-color: var(--pale-green);
            color: var(--dark-blue);
        }

        /* ====== BUTTONS ====== */
        button.btn-primary {
            background: var(--dark-blue);
            color: #fff;
            padding: 10px 22px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }
        button.btn-primary:hover {
            background: var(--light-blue);
        }

        .btn-secondary {
            background: var(--tan);
            border: 2px solid var(--pale-green);
            padding: 10px 18px;
            border-radius: 6px;
            color: var(--dark-blue);
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-secondary:hover {
            background: var(--pale-green);
            color: #fff;
        }

    </style>
</head>

<body>

<div class="site-nav">
  <div class="brand">APEX-Healthcare</div>
  <div><a href="/admin_home" class="btn">Admin</a> &nbsp; <a href="/logout" class="btn btn-primary">Logout</a></div>
  
</div>

<div class="auth-wrap">
  <div class="auth-card" style="max-width:760px; margin:0 auto;">

    <h2>Doctor's Appointment</h2>

    @if($errors->any())
      <div class="alert error">
        <ul style="margin:0;padding-left:18px;">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    <form id="apptForm" method="POST" action="{{ route('appointments.store') }}">
      @csrf

      <div class="form-grid">

        <div>
          <label>Patient ID</label>
          <input id="patient_id" name="patient_id" type="text" />
          <div class="small-note">Enter existing Patient UserID (patient must exist)</div>
        </div>

        <div>
          <label>Patient Name</label>
          <input id="patient_name" type="text" readonly />
        </div>

        <div>
          <label>Date & Time</label>
          <input id="date" name="date" type="datetime-local" value="{{ $default_date }}T09:00" />
          <div class="small-note">Pick the appointment date/time. Doctor dropdown will update based on roster.</div>
        </div>

        <div>
          <label>Doctor</label>
          <select id="doctor_id" name="doctor_id">
            <option value="">Select a doctor</option>
            @foreach($doctors as $d)
              <option value="{{ $d['id'] }}">{{ $d['name'] }}</option>
            @endforeach
          </select>
        </div>

        <div class="full">
          <label>Status</label>
          <input name="status" type="text" value="Scheduled" />
        </div>

      </div>

      <div style="margin-top:22px;">
        @if($role === 2)
          <button type="button" class="btn-secondary" disabled>Doctors cannot create appointments</button>
        @else
          <button type="submit" class="btn-primary">OK</button>
        @endif

        <a href="/admin_home" class="btn-secondary" style="margin-left:8px;">Cancel</a>
      </div>

    </form>

  </div>
</div>

<script>
  // helper function to fetch JSON with error handling
  async function fetchJSON(url) {
    const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (!r.ok) throw new Error('Fetch failed: ' + r.status);
    return r.json();
  }

  // Patient name lookup
  document.getElementById('patient_id').addEventListener('change', async function(){
    const pid = this.value.trim();
    const nameField = document.getElementById('patient_name');
    nameField.value = '';
    if (!pid) return;
    try {
      const data = await fetchJSON('/ajax/appointment-patient-name/' + encodeURIComponent(pid));      if (data.found) nameField.value = data.full_name;
    } catch (e) {
      // not found, leave blank
      console.log(e);
    }
  });

  // When date changes, request doctors for that date
  async function refreshDoctorsForDate() {
    const dateInput = document.getElementById('date').value;
    let dateOnly = new Date(dateInput);
    if (isNaN(dateOnly)) dateOnly = new Date();
    const yyyy = dateOnly.getFullYear();
    const mm = String(dateOnly.getMonth()+1).padStart(2,'0');
    const dd = String(dateOnly.getDate()).padStart(2,'0');
    const dateParam = yyyy + '-' + mm + '-' + dd;

    try {
      const res = await fetchJSON('/ajax/doctors-by-date?date=' + encodeURIComponent(dateParam));
      const sel = document.getElementById('doctor_id');
      sel.innerHTML = '<option value=\"\">Select a doctor</option>';
      (res.doctors || []).forEach(d => {
        const opt = document.createElement('option');
        opt.value = d.id;
        opt.textContent = d.name;
        sel.appendChild(opt);
      });
    } catch (e) {
      console.error(e);
    }
  }

  document.getElementById('date').addEventListener('change', refreshDoctorsForDate);
  // initial load
  document.addEventListener('DOMContentLoaded', refreshDoctorsForDate);
</script>

</body>
</html>
