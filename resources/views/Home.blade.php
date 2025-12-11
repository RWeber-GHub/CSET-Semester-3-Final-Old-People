<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APEX HealthCare - Home</title>
    <style>
        :root {
            --dark-blue: #003056;
            --pale-green: #8DB750;
            --light-blue: #5980BE;
            --tan: #F8F1CE;
            --white: #ffffff;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--white);
            color: #000;
        }

        /* TOP NAV */
        .top-nav {
            background: var(--tan);
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
            color: var(--white);
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: bold;
        }

        /* MAIN NAV */
        .main-nav {
            background: var(--dark-blue);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
        }
        .main-nav .logo {
            color: var(--white);
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
            color: var(--white);
            padding: 8px 14px;
            border-radius: 6px;
            transition: 0.3s;
        }
        .main-nav ul li a:hover {
            background: var(--light-blue);
        }
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
            padding: 100px 20px;
            background: var(--tan);
        }
        header h1 {
            color: var(--dark-blue);
            font-size: 3rem;
            margin-bottom: 20px;
        }
        header p {
            color: #333;
            font-size: 1.3rem;
        }

        /* FEATURE SECTIONS */
        .features {
            display: flex;
            flex-wrap: wrap;
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
            font-size: 1.5rem;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 20px;
            background: var(--dark-blue);
            color: #fff;
            margin-top: 40px;
        }

        /* Responsive */
        @media (max-width: 960px) {
            .features {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    
    <!-- MAIN NAV -->
    <nav class="main-nav">
        <div class="logo">APEX - HealthCare</div>
        <ul>
            @auth
                <li><a href="/home" class="btn-important">Home</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/logout" class="btn-important">Logout</a></li>
                <li><a href="/roster" class="btn-important">Roster</a></li>
            @endauth
            @guest
                <li><a href="/login" class="btn-important">Login</a></li>
                <li><a href="/register">Register</a></li>
            @endguest
        </ul>
    </nav>

    <!-- HERO SECTION -->
    <header>
        <h1>Welcome to APEX Nursing Home</h1>
        <p>Providing compassionate, professional, and modern care for seniors in a safe and comfortable environment.</p>
    </header>

    <!-- FEATURES -->
    <section class="features">
        <div class="feature-box">
            <h3>Quality Care</h3>
            <p>Our trained staff provides 24/7 support ensuring residents’ well-being, health monitoring, and daily assistance.</p>
        </div>
        <div class="feature-box">
            <h3>Community & Engagement</h3>
            <p>Residents enjoy social activities, games, and events that foster friendships and mental stimulation.</p>
        </div>
        <div class="feature-box">
            <h3>Safe Environment</h3>
            <p>Modern facilities, secure living spaces, and personalized care plans create a safe, comfortable home for every resident.</p>
        </div>
        <div class="feature-box">
            <h3>Nutrition & Wellness</h3>
            <p>Balanced meals, health programs, and exercise options are provided to support physical and mental wellness.</p>
        </div>
    </section>

    <footer>
        © 2025 APEX HealthCare — All Rights Reserved
    </footer>
</body>
</html>
