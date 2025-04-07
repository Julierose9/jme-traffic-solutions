
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Officer Dashboard - JME Traffic Violation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #edf2f7;
        }

        .sidebar {
            width: 18rem; 
            background-color: #0a1f44;
            color: #ffffff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 1rem;
        }

        .sidebar .logo {
            width: 7rem;
            margin: 0 auto 1rem;
            display: block;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem; 
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .sidebar nav a i {
            margin-right: 0.75rem; 
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            background-color: #102a5a; 
        }

        .logout-btn {
            margin-top: auto;
            padding: 1rem;
        }

        .logout-btn button {
            width: 100%;
            background-color: #dc2626;
            color: #ffffff;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .main-content {
            margin-left: 18rem; 
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .stats-card {
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stats-card h2 {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
        }

        .stats-card p {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0a1f44;
        }

        .feature-section {
            margin-top: 2rem;
        }

        .feature-section h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #0a1f44;
        }

        .feature-section ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .feature-section ul li {
            margin: 0.5rem 0;
        }
        .dropdown-btn {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem; 
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .dropdown-btn {
            cursor: pointer;
        }

        .dropdown-btn i {
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ url('/dashboard/officer') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('officer.violation.issue') }}"><i class="fas fa-exclamation-triangle"></i> Issue Violation</a>
                <a href="#"><i class="fas fa-folder-open"></i> Reports</a>
            </nav>
            <div class="logout-btn mt-auto px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1 class="text-2xl font -bold mb-4">Officer Dashboard</h1>
            <div class="stats-grid">
                <div class="stats-card">
                    <h2>TICKETS ISSUED</h2>
                    <p>0</p>
                </div>
                <div class="stats-card">
                    <h2>ACTIVE VIOLATIONS</h2>
                    <p>0</p>
                </div>
                <div class="stats-card">
                    <h2>RESOLVED CASES</h2>
                    <p>0</p>
                </div>
                <div class="stats-card">
                    <h2>TODAY'S REPORTS</h2>
                    <p>0</p>
                </div>
            </div>
        
        </div>
    </div>
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>
</body>
</html>