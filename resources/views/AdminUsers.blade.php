<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending User Approvals</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 12px;
        }
        .table th {
            background: #343a40;
            color: white;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        .btn-approve:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 mb-4">
    <a class="navbar-brand" href="/admin_home">Admin Panel</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="/admin_home" class="nav-link">Dashboard</a></li>
            <li class="nav-item"><a href="/logout" class="nav-link text-danger">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">

    <h2 class="mb-4 fw-bold">Pending User Approvals</h2>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- No Pending Users --}}
    @if ($pendingUsers->isEmpty())
        <div class="alert alert-info">There are no users waiting for approval.</div>
    @else

        <div class="card shadow-sm p-3">
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
                            <th style="width: 180px;">Actions</th>
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
                                        <br>
                                        <small class="text-muted">{{ $user->Emergency_Contact_Relation }}</small>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                                </td>

                                <td>

                                    <!-- Approve Button -->
                                    <button class="btn btn-approve btn-sm w-100 mb-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approveModal{{ $user->UserID }}">
                                        Approve
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="btn btn-delete btn-sm w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $user->UserID }}">
                                        Delete
                                    </button>

                                </td>
                            </tr>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $user->UserID }}" tabindex="-1">
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
                            <div class="modal fade" id="deleteModal{{ $user->UserID }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger">Delete User</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete
                                            <strong>{{ $user->First_Name }} {{ $user->Last_Name }}</strong>?
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

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
