<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="css/towerhealth.css">

    <style>
        /* Color Palette */
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --white: #fff;
            --text: #000;
        }

        body {
            background: var(--white);
            color: var(--text);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
            color: var(--dark-blue);
        }
        
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

        /* LAYOUT */
        .auth-wrap {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--white);
            padding: 28px;
            width: 420px;
            border-radius: 10px;
            border: 2px solid var(--pale-green);
            box-shadow: 0 3px 9px rgba(0,0,0,0.1);
        }

        h2 {
            color: var(--dark-blue);
            margin-bottom: 20px;
            text-align: center;
        }

        /* Alerts */
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .alert.error {
            background: var(--tan);
            border-left: 5px solid red;
        }
        .alert.success {
            background: var(--tan);
            border-left: 5px solid var(--pale-green);
        }

        /* FORM */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 2px solid var(--dark-blue);
            margin-bottom: 14px;
        }

        /* BUTTONS */
        .btn-primary {
            background: var(--dark-blue);
            color: var(--white);
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background: var(--pale-green);
        }

        /* Small text */
        p {
            margin-top: 16px;
            text-align: center;
        }
        p a {
            color: var(--dark-blue);
            font-weight: bold;
        }
        p a:hover {
            color: var(--light-blue);
        }
    </style>
</head>

<body>
    <div class="site-nav">
        <div class="brand">APEX HealthCare</div>
        <div>
            <a href="/">Home</a>
        </div>
    </div>

<div class="auth-wrap">
    <div class="auth-card">

        <h2>Login</h2>

        @if ($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>

            <button type="submit" class="btn-primary">Login</button>
        </form>

        <p>
            Don’t have an account?
            <a href="/register">Register</a>
        </p>

    </div>
</div>

</body>
</html>
