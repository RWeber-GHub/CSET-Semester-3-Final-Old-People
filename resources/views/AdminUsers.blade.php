<!DOCTYPE html>
<html>
<head>
    <title>Admin - Pending Users</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        button { padding: 6px 12px; cursor: pointer; }
        .approve-btn { background-color: #4CAF50; color: white; border: none; }
        .delete-btn { background-color: #e74c3c; color: white; border: none; }
    </style>
</head>
<body>

<h2>Pending User Approvals</h2>

@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

@if($pendingUsers->isEmpty())
    <p>No pending users.</p>
@else
    <table>
        <tr>
            <th>UserID</th>
            <th>Name</th>
            <th>Email</th>
            <th>RoleID</th>
            <th>Actions</th>
        </tr>

        @foreach($pendingUsers as $user)
        <tr>
            <td>{{ $user->UserID }}</td>
            <td>{{ $user->First_Name }} {{ $user->Last_Name }}</td>
            <td>{{ $user->Email }}</td>
            <td>{{ $user->RoleID }}</td>
            <td>

                {{-- Approve Form --}}
                <form action="{{ route('admin.users.approve', $user->UserID) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="approve-btn">Approve</button>
                </form>

                {{-- Delete Form --}}
                <form action="{{ route('admin.users.delete', $user->UserID) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="delete-btn">Delete</button>
                </form>

            </td>
        </tr>
        @endforeach

    </table>
@endif

</body>
</html>
