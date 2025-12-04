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
