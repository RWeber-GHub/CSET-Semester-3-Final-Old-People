<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/towerhealth.css') }}">
</head>
<body>

<div class="site-nav">
    <div class="brand">APEX HealthCare</div>
    <div>
        <a href="/">Home</a>
        <a href="/register" class="btn">Register</a>
    </div>
</div>

<div class="auth-wrap">
    <div class="auth-card" style="max-width:480px; margin: 0 auto;">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div style="margin-bottom:12px;">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div style="margin-bottom:12px;">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <div style="margin-top:8px;">
                <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
            </div>
        </form>

        <p style="text-align:center; margin-top:12px; color:var(--muted);">
            Don't have an account? <a href="/register">Register</a>
        </p>
    </div>
</div>

</body>
</html>
