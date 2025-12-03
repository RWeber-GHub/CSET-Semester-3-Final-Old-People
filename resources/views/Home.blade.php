<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --background: #ffffff;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--background);
        }

        .top-nav {
            background: #f8f8f8;
            padding: 8px 40px;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }
        .top-nav ul {
            display: flex;
            gap: 25px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .top-nav ul li a {
            text-decoration: none;
            color: var(--dark-blue);
        }
        .contact-btn {
            background: var(--dark-blue);
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: bold;
        }

        .main-nav {
            background: var(--background);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            border-bottom: 3px solid var(--pale-green);
        }
        .main-nav .logo {
            color: var(--dark-blue);
            font-size: 1.8rem;
            font-weight: bold;
        }
        .main-nav ul {
            display: flex;
            gap: 20px;
            list-style: none;
        }
        .main-nav ul li a {
            text-decoration: none;
            color: var(--dark-blue);
            padding: 8px 14px;
            border-radius: 6px;
        }
        .main-nav ul li a:hover {
            background: var(--light-blue);
            color: white;
        }

        /* NAVBAR */
        nav {
            background: var(--dark-blue);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }

        /* Blue accents for menu items */
        nav ul li a:hover {
            background: var(--light-blue);
        }

        /* Pale green for important buttons */
        .btn-important {
            background: var(--pale-green);
            color: #fff !important;
            padding: 8px 15px;
            border-radius: 6px;
        }

        .btn-important:hover {
            opacity: 0.85;
        }

        /* HERO SECTION */
        header {
            text-align: center;
            padding: 80px 20px;
            background: var(--tan);
        }

        header h1 {
            color: var(--dark-blue);
            font-size: 3rem;
        }

        header p {
            color: #444;
            font-size: 1.2rem;
        }

        /* FEATURE SECTIONS */
        .features {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 60px 20px;
        }

        .feature-box {
            background: var(--light-blue);
            color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 280px;
            text-align: center;
        }

        .feature-box h3 {
            margin-top: 0;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: var(--dark-blue);
            color: #fff;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <ul>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Insurance</a></li>
            <li><a href="#">Pay My Bill</a></li>
            <li><a href="#">Pharmacy</a></li>
            <li><a href="#">Price Estimation</a></li>
            <li><a href="#">Appointments</a></li>
            <li><a href="#">Research</a></li>
        </ul>
        <div class="contact-btn">9-999-99-APEX</div>
    </nav>

    <nav class="main-nav">
        <div class="logo">My Website</div>
        <ul>
            @auth
                <li><a href="/home" class="btn-important">Home</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/logout" class="btn-important">Logout</a></li>
                <li><a href="/roster" class="btn-important">Roster</a></li>
            @endauth

            @important
                <li><a href="/NewRoster" class="btn-important">New Roster</a></li>

            @guest
                <li><a href="/login" class="btn-important">Login</a></li>
                <li><a href="/register">Register</a></li>
            @endguest
        </ul>
    </nav>

    <header>
        <h1>Welcome to Our Homepage</h1>
        <p>Your modern and clean Laravel-compatible layout</p>
    </header>

    <section class="features">
        <div class="feature-box">
            <h3>Fast</h3>
            <p>Laravel 10 helps you build apps quickly and efficiently.</p>
        </div>
        <div class="feature-box">
            <h3>Secure</h3>
            <p>Built‑in authentication and protection out of the box.</p>
        </div>
        <div class="feature-box">
            <h3>Modern</h3>
            <p>Clean structure, easy routing, and powerful tools.</p>
        </div>
    </section>

    <footer>
        © 2025 My Website — All Rights Reserved
    </footer>
</body>
</html>
