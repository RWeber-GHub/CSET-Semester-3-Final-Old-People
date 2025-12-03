<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/towerhealth.css">
</head>
<body>

<div class="site-nav">
    <div class="brand">TOWER HEALTH - APEX</div>
    <div>
        <a href="/">Home</a>
        <a href="/login" class="btn">Login</a>
    </div>
</div>

<div class="auth-wrap">
    <div class="auth-card">
        <h2>Create an Account</h2>

        @if ($errors->any())
            <div class="alert error">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
            @csrf

            <div class="form-grid">

                <div>
                    <label for="first_name">First Name</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required>
                </div>

                <div>
                    <label for="last_name">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required>
                </div>

                <div class="full">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                </div>

                <div class="full">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required>
                </div>

                <div class="full">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <div class="full">
                    <label for="roleid">Role</label>
                    <select id="roleid" name="roleid" required onchange="toggleRoleFields()">
                        <option value="">Select Role</option>
                        <option value="1" {{ old('roleid') == '1' ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ old('roleid') == '2' ? 'selected' : '' }}>Doctor</option>
                        <option value="3" {{ old('roleid') == '3' ? 'selected' : '' }}>Patient</option>
                        <option value="4" {{ old('roleid') == '4' ? 'selected' : '' }}>Caregiver</option>
                        <option value="5" {{ old('roleid') == '5' ? 'selected' : '' }}>Family Member</option>
                        <option value="6" {{ old('roleid') == '7' ? 'selected' : '' }}>Supervisor</option>
                    </select>
                </div>

                <!-- Patient only -->
                <div id="patientSection" class="full" style="display:none;">
                    <label class="font-medium">Patient Details</label>

                    <div style="margin-top:10px;">
                        <label for="date_of_birth">Date of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}">
                    </div>

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

            <div style="margin-top:18px;">
                <button type="submit" class="btn btn-primary">Create Account</button>
                <a href="/login" style="margin-left:12px;" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleRoleFields() {
        const role = document.getElementById('roleid').value;
        const patientSection = document.getElementById('patientSection');
        const familySection = document.getElementById('familySection');

        patientSection.style.display = (role === '3') ? 'block' : 'none';
        familySection.style.display = (role === '5') ? 'block' : 'none';
    }

    // initial on load (for old values)
    document.addEventListener('DOMContentLoaded', function(){
        toggleRoleFields();
    });
</script>

</body>
</html>
