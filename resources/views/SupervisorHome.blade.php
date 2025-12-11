<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Home - APEX</title>

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
            background: var(--tan);
        }

        nav {
            background: var(--dark-blue);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            color: var(--white);
            font-size: 1.8rem;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: var(--white);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            transition: 0.3s;
        }

        nav ul li a:hover {
            background: var(--light-blue);
        }

        .btn-important {
            background: var(--pale-green);
            color: white !important;
            padding: 8px 15px;
            border-radius: 6px;
        }

        .page-container {
            max-width: 800px;
            margin: 50px auto;
            background: var(--white);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 3px 10px #0003;
            text-align: center;
        }

        h1 {
            color: var(--dark-blue);
            margin-bottom: 30px;
        }

        .menu-btn {
            display: block;
            width: 70%;
            margin: 15px auto;
            background: var(--light-blue);
            color: white;
            padding: 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .menu-btn:hover {
            background: var(--pale-green);
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">APEX HealthCare</div>
        <ul>
            <li><a href="/roster" class="btn-important">Roster</a></li>
            <li><a href="/logout" class="btn-important">Logout</a></li>
        </ul>
    </nav>

    <div class="page-container">
        <h1>Supervisor Home</h1>

        <a href="/roster" class="menu-btn">View Roster</a>
        <a href="/new-roster" class="menu-btn">Create New Roster</a>
    </div>

</body>
</html>