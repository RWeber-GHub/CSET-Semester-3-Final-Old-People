<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 12px;
        }
        .dashboard-header {
            font-size: 2rem;
            font-weight: 600;
        }
        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
    </style>
</head>
<body>

    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users') }}">User Approvals</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/roster">Roster</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/prescriptions">Prescriptions</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="/logout">Logout</a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container mt-5">

        <h1 class="dashboard-header mb-4">Welcome, Admin</h1>

        <div class="row g-4">

            <!-- Pending Users -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Pending Users</h5>
                    <p class="text-muted">Users awaiting approval.</p>

                    <h3 class="fw-bold">
                        {{ $pendingCount ?? '0' }}
                    </h3>

                    <a href="{{ route('admin.users') }}" class="btn btn-primary">
                    Review Users
                    </a>

                </div>
            </div>

            <!-- Roster -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Roster Management</h5>
                    <p class="text-muted">Create and manage schedules.</p>

                    <a href="/roster" class="btn btn-primary mt-4 w-100">
                        Open Roster
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">System Overview</h5>
                    <p class="text-muted">General information and logs.</p>

                    <a href="#" class="btn btn-secondary mt-4 w-100 disabled">
                        Coming Soon
                    </a>
                </div>
            </div>
        </div>

        <!-- Lower Section -->
        <div class="row g-4 mt-4">

            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5>Quick Actions</h5>
                    <ul class="list-group mt-3">
                        <li class="list-group-item"><a href="{{ route('admin.users') }}">Approve Users</a></li>
                        <li class="list-group-item"><a href="/new-roster">Create New Roster</a></li>
                        <li class="list-group-item"><a href="/logout" class="text-danger">Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5>Admin Notes</h5>
                    <textarea class="form-control mt-3" rows="6" placeholder="Write notes..."></textarea>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .card { border-radius: 12px; }
        .table th { background: #343a40; color: white; }
        .btn-approve { background-color: #28a745; color: white; }
        .btn-approve:hover { background-color: #218838; }
        .btn-delete { background-color: #dc3545; color: white; }
        .btn-delete:hover { background-color: #c82333; }
    </style>
</head>
<body>

    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="/admin_home">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/admin_home">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/roster">Roster</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/prescriptions">Prescriptions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container mt-4">
        <h1 class="mb-4">Admin Dashboard</h1>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Pending Users</h5>
                    <h3 class="fw-bold">{{ $pendingUsers->count() ?? '0' }}</h3>
                </div>
            </div>
            <!-- Add other cards as needed -->
        </div>

        <!-- User Approval Table -->
        <div class="card shadow-sm p-3">
            <h2 class="mb-4">Pending User Approvals</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($pendingUsers->isEmpty())
                <div class="alert alert-info">There are no users waiting for approval.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Date of Birth</th>
                                <th>Emergency Contact</th>
                                <th>Added On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingUsers as $user)
                            <tr>
                                <td>{{ $user->First_Name }} {{ $user->Last_Name }}</td>
                                <td>{{ $user->Email }}</td>
                                <td>{{ $user->Phone }}</td>
                                <td>
                                    @switch($user->RoleID)
                                        @case(1) Admin @break
                                        @case(2) Doctor @break
                                        @case(3) Patient @break
                                        @case(4) Caregiver @break
                                        @case(5) Family Member @break
                                        @default Unknown
                                    @endswitch
                                </td>
                                <td>{{ $user->Date_of_Birth ?? '—' }}</td>
                                <td>
                                    @if ($user->Emergency_Contact)
                                        {{ $user->Emergency_Contact }}
                                        <br><small class="text-muted">{{ $user->Emergency_Contact_Relation }}</small>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-approve btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#approveModal{{ $user->UserID }}">Approve</button>
                                    <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->UserID }}">Delete</button>
                                    
                                    <!-- Modals (copy from adminusers.php) -->
                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal{{ $user->UserID }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Approve User</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Approve <strong>{{ $user->First_Name }} {{ $user->Last_Name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="/admin/users/approve/{{ $user->UserID }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-approve">Approve</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $user->UserID }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger">Delete User</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete <strong>{{ $user->First_Name }} {{ $user->Last_Name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="/admin/users/delete/{{ $user->UserID }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-delete">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>