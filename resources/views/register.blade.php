<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">

        <h2 class="text-2xl font-bold text-center mb-6">Create an Account</h2>

        {{-- Display Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="font-medium">First Name</label>
                    <input type="text" name="First_Name" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label class="font-medium">Last Name</label>
                    <input type="text" name="Last_Name" class="w-full p-2 border rounded" required>
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Email</label>
                    <input type="email" name="Email" class="w-full p-2 border rounded" required>
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Phone</label>
                    <input type="text" name="Phone" class="w-full p-2 border rounded" required>
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Password</label>
                    <input type="password" name="Password" class="w-full p-2 border rounded" required>
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Role</label>
                    <select name="RoleID" class="w-full p-2 border rounded" required>
                        <option value="">Select Role</option>
                        <option value="1">Admin</option>
                        <option value="2">Doctor</option>
                        <option value="3">Patient</option>
                        <option value="4">Caregiver</option>
                        <option value="5">Family Member</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Date of Birth</label>
                    <input type="date" name="Date_of_Birth" class="w-full p-2 border rounded">
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Family Code (optional)</label>
                    <input type="text" name="Family_Code" class="w-full p-2 border rounded">
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Emergency Contact</label>
                    <input type="text" name="Emergency_Contact" class="w-full p-2 border rounded">
                </div>

                <div class="col-span-2">
                    <label class="font-medium">Emergency Contact Relation</label>
                    <input type="text" name="Emergency_Contact_Relation" class="w-full p-2 border rounded">
                </div>

            </div>

            <button
                class="w-full mt-5 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm mt-4">
            Already have an account?
            <a href="/login" class="text-blue-600 hover:underline">Login</a>
        </p>

    </div>
</div>

</body>
</html>
