<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --background: #ffffff;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--background);
        }

        /* NAVIGATION */
        nav {
            background: var(--dark-blue);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }
        nav ul li a:hover {
            background: var(--light-blue);
        }

        .btn-important {
            background: var(--pale-green);
            color: #fff !important;
        }

        /* FORM CONTAINER */
        .register-container {
            width: 900px;
            margin: 50px auto;
            background: var(--tan);
            padding: 30px;
            border-radius: 10px;
            border: 3px solid var(--pale-green);
        }
        h2 {
            color: var(--dark-blue);
            text-align: center;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-top: 25px;
        }

        label {
            font-weight: bold;
            color: var(--dark-blue);
        }

        input, select {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 2px solid var(--light-blue);
            border-radius: 6px;
        }

        .patient-section {
            background: white;
            border: 2px solid var(--light-blue);
            padding: 20px;
            border-radius: 10px;
            grid-column: span 2;
            display: none;
        }
        .patient-section h3 {
            margin-top: 0;
            background: var(--light-blue);
            color: white;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }

        .button-row {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .btn {
            padding: 12px 30px;
            font-size: 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .ok-btn {
            background: var(--pale-green);
            color: white;
        }
        .cancel-btn {
            background: var(--dark-blue);
            color: white;
        }
    </style>

    <script>
        function togglePatientFields() {
            const role = document.getElementById('role').value;
            const patientFields = document.getElementById('patientFields');

            patientFields.style.display = (role === 'patient') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <nav>
        <div class="logo">APEX Health</div>
        <ul>
            <li><a href="/home">Home</a></li>
            <li><a href="/login" class="btn-important">Login</a></li>
            <li><a href="/register">Register</a></li>
        </ul>
    </nav>

    <div class="register-container">
        <h2>Register</h2>

        <form>
            <div class="form-grid">

                <div>
                    <label>Role</label>
                    <select id="role" onchange="togglePatientFields()">
                        <option value="">Select Role</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="doctor">Doctor</option>
                        <option value="caregiver">Caregiver</option>
                        <option value="patient">Patient</option>
                        <option value="family member">Family Member</option>
                    </select>
                </div>

                <div>
                    <label>First Name</label>
                    <input type="text" />
                </div>

                <div>
                    <label>Last Name</label>
                    <input type="text" />
                </div>

                <div>
                    <label>Email ID</label>
                    <input type="email" />
                </div>

                <div>
                    <label>Phone</label>
                    <input type="text" />
                </div>

                <div>
                    <label>Password</label>
                    <input type="password" />
                </div>

                <!-- PATIENT-ONLY SECTION -->
                <div id="patientFields" class="patient-section">
                    <h3>Patient Details</h3>

                    <label>Date of Birth</label>
                    <input type="date" />

                    <label>Family Code (for Patient Family Member)</label>
                    <input type="text" />

                    <label>Emergency Contact</label>
                    <input type="text" />

                    <label>Relation to Emergency Contact</label>
                    <input type="text" />
                </div>

            </div>

            <div class="button-row">
                <button class="btn ok-btn">OK</button>
                <button class="btn cancel-btn" type="reset">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
