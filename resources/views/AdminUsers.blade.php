<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending User Approvals</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6 text-center">Pending User Approvals</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if ($pendingUsers->isEmpty())
        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-gray-600">No pending users — everything is up to date!</p>
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Registered</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pendingUsers as $user)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3">
                                {{ $user->First_Name }} {{ $user->Last_Name }}
                            </td>

                            <td class="p-3">{{ $user->Email }}</td>

                            <td class="p-3">
                                @php
                                    $roles = [
                                        1 => 'Admin',
                                        2 => 'Doctor',
                                        3 => 'Patient',
                                        4 => 'Caregiver',
                                        5 => 'Family Member'
                                    ];
                                @endphp
                                {{ $roles[$user->RoleID] ?? 'Unknown' }}
                            </td>

                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                            </td>

                            <td class="p-3 flex gap-2 justify-center">

                                {{-- Approve Button --}}
                                <form method="POST" action="/admin/users/approve/{{ $user->UserID }}">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Approve
                                    </button>
                                </form>

                                {{-- Reject/Delete Button --}}
                                <form method="POST" action="/admin/users/delete/{{ $user->UserID }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Reject
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @endif

</div>

</body>
</html>
