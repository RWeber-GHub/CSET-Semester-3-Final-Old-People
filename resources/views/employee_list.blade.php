<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee List</title>

<style>
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

    .container {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 0 10px #0002;
        max-width: 1100px;
        margin: auto;
    }

    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background: var(--light-blue); color: #fff; }

    tr:nth-child(even) td { background: #f0f4ff; }
    input, select {
        width: 100%;
        padding: 6px;
        border-radius: 5px;
        border: 1px solid #aaa;
    }

    .salary-box {
        margin-top: 30px;
        background: var(--tan);
        padding: 20px;
        border-radius: 10px;
        border: 2px solid var(--pale-green);
        width: 400px;
    }

    .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; }
    .btn-ok { background: var(--pale-green); color: #fff; margin-top: 15px; }
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
</style>
</head>
<body>

    
<div class="site-nav">
    <div class="brand">APEX HealthCare</div>
    <div>
        <a href="/admin_home">Home</a>
        <a href="/roster">Roster</a>
        <a href="/logout" class="btn btn-primary">Logout</a>
        
    </div>
</div>

<div class="container">

    <h1>Employee List</h1>

    <!-- Search Filters -->
    <form method="GET">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Salary</th>
            </tr>

            <tr>
                <td><input name="id" placeholder="Search ID" value="{{ request('id') }}"></td>
                <td><input name="name" placeholder="Search Name" value="{{ request('name') }}"></td>

                <td>
                    <select name="role">
                        <option value="">All</option>
                        @foreach($roles as $roleName)
                            <option value="{{ $roleName }}"
                                {{ request('role') == $roleName ? 'selected' : '' }}>
                                {{ $roleName }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td><input name="salary" placeholder="Salary" value="{{ request('salary') }}"></td>
            </tr>

            @foreach($employees as $emp)
                <tr>
                    <td>{{ $emp->EmployeeID }}</td>
                    <td>{{ $emp->First_Name }} {{ $emp->Last_Name }}</td>
                    <td>{{ $emp->Role }}</td>
                    <td>${{ number_format($emp->Salary, 2) }}</td>
                </tr>
            @endforeach
        </table>

        <button class="btn btn-ok">Apply Filters</button>
    </form>

    <!-- Salary Update -->
    <div class="salary-box">
        <h3>Update Salary</h3>

        @if(session('success'))
            <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('employees.updateSalary') }}">
            @csrf

            <label>Employee ID</label>
            <input name="employee_id" required>

            <label>New Salary</label>
            <input name="new_salary" required>

            <button class="btn btn-ok">Ok</button>
        </form>
    </div>

</div>

</body>
</html>