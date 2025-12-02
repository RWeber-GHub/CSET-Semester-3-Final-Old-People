<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        {{-- Show Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Success Message (ex: from registration) --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-4">
                <label class="font-medium">Email</label>
                <input type="email" name="Email" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-medium">Password</label>
                <input type="password" name="Password" class="w-full p-2 border rounded" required>
            </div>

            <button
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm mt-4">
            Don't have an account? 
            <a href="/register" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>
</div>

</body>
</html>
