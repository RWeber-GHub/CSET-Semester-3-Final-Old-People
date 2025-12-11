<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>

    <!-- Use your main stylesheet -->
    <link rel="stylesheet" href="css/towerhealth.css">

    <style>
        /* Color Scheme */
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

        .btn-danger {
            background-color: #D9534F;
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #B52B2B;
        }

        /* Center Card Layout */
        .auth-wrap {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--white);
            padding: 28px;
            width: 680px;
            border-radius: 10px;
            border: 2px solid var(--pale-green);
            box-shadow: 0 3px 9px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: var(--dark-blue);
        }

        /* Alerts */
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .alert.error {
            background: var(--tan);
            border-left: 5px solid red;
        }

        .alert.success {
            background: var(--tan);
            border-left: 5px solid var(--pale-green);
        }

        /* Form Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .form-grid .full {
            grid-column: span 2;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 2px solid var(--dark-blue);
        }

        /* Section Titles */
        #patientSection label.font-medium {
            color: var(--dark-blue);
            font-size: 1.1rem;
        }

        /* Tan Info Section */
        #patientSection,
        #familySection {
            background: var(--tan);
            padding: 12px;
            border-radius: 6px;
            border: 1px solid var(--pale-green);
        }
    </style>
</head>

<body>

<div class="site-nav">
    <div class="brand">APEX HealthCare</div>
    <div>
        <a href="/">Home</a>
        <a href="/appointments/create">Create Appointment</a>
        <a href="/roster">Roster</a>
        <a href="/logout" class="btn btn-primary">Login</a>
        
    </div>
</div>

<div class="auth-wrap">
    <div class="auth-card">

        <h2>Create an Account</h2>

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
            @csrf

            <div class="form-grid">

                <div>
                    <label for="first_name">First Name</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" style="width: 75%" required>
                </div>

                <div>
                    <label for="last_name">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" style="width: 75%" required>
                </div>

                <div class="full">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" style="width: 75%" required>
                </div>

                <div class="full">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" style="width: 75%" required>
                </div>

                <div class="full">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" style="width: 75%"     required>
                </div>

                <div style="full">
                        <label for="date_of_birth">Date of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}">
                    </div>
                <div class="full">
                    <label for="roleid">Role</label>
                    <select id="roleid" name="roleid" required onchange="toggleRoleFields()">
                        <option value="">Select Role</option>
                        <option value="1">Admin</option>
                        <option value="2">Doctor</option>
                        <option value="3">Patient</option>
                        <option value="4">Caregiver</option>
                        <option value="5">Family Member</option>
                        <option value="6">Supervisor</option>
                    </select>
                </div>

                <!-- Patient only -->
                <div id="patientSection" class="full" style="display:none;">
                    <label class="font-medium">Patient Details</label>


                    <div style="margin-top:10px;">
                        <label for="family_code">Family Code (optional)</label>
                        <input id="family_code" name="family_code" type="text" value="{{ old('family_code') }}">
                    </div>

                    <div style="margin-top:10px;">
                        <label for="emergency_contact">Emergency Contact</label>
                        <input id="emergency_contact" name="emergency_contact" type="text" value="{{ old('emergency_contact') }}">
                    </div>

                    <div style="margin-top:10px;">
                        <label for="emergency_contact_relation">Emergency Contact Relation</label>
                        <input id="emergency_contact_relation" name="emergency_contact_relation" type="text" value="{{ old('emergency_contact_relation') }}">
                    </div>
                </div>

                <!-- Family Member only -->
                <div id="familySection" class="full" style="display:none;">
                    <label for="family_code_family">Family Code (match patient)</label>
                    <input id="family_code_family" name="family_code_family" type="text" value="{{ old('family_code_family') }}">
                </div>

            </div>

            <div style="margin-top:20px;">
                <button type="submit" class="btn-primary">Create Account</button>
                <a href="/login" class="btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>

<script>
    function toggleRoleFields() {
        const role = document.getElementById('roleid').value;
        document.getElementById('patientSection').style.display = (role === '3') ? 'block' : 'none';
        document.getElementById('familySection').style.display = (role === '5') ? 'block' : 'none';
    }
    document.addEventListener('DOMContentLoaded', toggleRoleFields);
</script>

</body>
</html>
