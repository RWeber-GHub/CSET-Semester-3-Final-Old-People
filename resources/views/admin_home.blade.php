    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Panel</title>
        <link rel="stylesheet" href="/css/towerhealth.css">

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

            /* Buttons */
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

            .btn-primary:hover {
                background-color: var(--dark-blue);
            }

            .btn-danger {
                background-color: #D9534F;
                color: var(--white);
            }

            .btn-danger:hover {
                background-color: #B52B2B;
            }

            /* Page Wrap */
            .page-wrap {
                padding: 30px;
            }

            /* Alerts */
            .alert {
                padding: 15px 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .alert.success {
                background-color: var(--green);
                color: var(--white);
            }

            /* Info Box */
            .info-box {
                background-color: var(--tan);
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
            }

            /* Tables */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            table th, table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid var(--gray);
            }

            table th {
                background-color: var(--light-blue);
                color: var(--white);
            }

            table tr:hover {
                background-color: #f2f2f2;
            }

            /* Search Section */
            .search-section {
                margin-top: 40px;
                padding: 25px;
                background: var(--white);
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }

            .search-row {
                display: flex;
                gap: 16px;
                flex-wrap: wrap;
            }

            .search-row input,
            .search-row select {
                width: 100%;
                max-width: 280px;
                padding: 8px;
                border: 1px solid var(--gray);
                border-radius: 6px;
            }

            /* Quick Jump */
            .quick-jump {
                text-align: right;
                margin-top: 20px;
            }

            /* Form inline styles */
            .form-inline {
                display: inline-block;
            }

            .action-buttons {
                display: flex;
                gap: 10px;
                flex-wrap: nowrap;
            }
        </style>
    </head>
    <body>

    <div class="site-nav">
        <div class="brand">APEX HealthCare</div>
        <div>
            <a href="/">Home</a>
            <a href="/patient-info">Patient Info</a>
            <a href="/appointments/create">Create Appointment</a>
            <a href="/roster">Roster</a>
            <a href="/employees">Employee Info</a>
            <a href="/admin/activity" class="btn">Patient Activity</a>
            <a href="/logout" class="btn btn-primary">Logout</a>
            
        </div>
    </div>

    <div class="page-wrap">

        <h1>Admin Dashboard</h1>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <h2>Pending User Approvals</h2>

        <table class="pending-table">
            <tr>
                <th>UserID</th>
                <th>Name</th>
                <th>Email</th>
                <th>RoleID</th>
                <th>Actions</th>
            </tr>

            @forelse ($pendingUsers as $user)
                <tr>
                    <td>{{ $user->UserID }}</td>
                    <td>{{ $user->First_Name }} {{ $user->Last_Name }}</td>
                    <td>{{ $user->Email }}</td>
                    <td>{{ $user->RoleID }}</td>
                    <td>
                        <div class="action-buttons">
                            <!-- Approve Form -->
                            <form action="{{ route('admin.user.approve', $user->UserID) }}" method="POST" class="form-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">Approve</button>
                            </form>
                            
                            <!-- Delete Form -->
                            <form action="{{ route('admin.user.delete', $user->UserID) }}" method="POST" class="form-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">No pending users.</td></tr>
            @endforelse
        </table>


        <div id="userSearch" class="search-section">
            <h2>User Search</h2>

            <form action="{{ route('admin.users') }}" method="GET">
                <div class="search-row">
                    <div>
                        <label>User ID</label>
                        <input type="number" name="userid" placeholder="Enter User ID"
                            value="{{ request('userid') }}">
                    </div>

                    <div>
                        <label>Name</label>
                        <input type="text" name="name" placeholder="First or Last Name"
                            value="{{ request('name') }}">
                    </div>

                    <div>
                        <label>Role</label>
                        <select name="role">
                            <option value="">-- Any Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->RoleID }}"
                                    {{ request('role') == $role->RoleID ? 'selected' : '' }}>
                                    {{ $role->Role_Name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-top:18px;">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            @if(isset($allUsers))
                <h3 style="margin-top:25px;">Search Results</h3>

                <table class="search-results">
                    <tr>
                        <th>UserID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Approved</th>
                    </tr>

                    @forelse ($allUsers as $u)
                        <tr>
                            <td>{{ $u->UserID }}</td>
                            <td>{{ $u->First_Name }} {{ $u->Last_Name }}</td>
                            <td>{{ $u->Email }}</td>
                            <td>{{ $u->Role_Name }}</td>
                            <td>{{ $u->Approved == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;">No users found.</td></tr>
                    @endforelse
                </table>
            @endif

        </div>

    </div>
    </body>
    </html>