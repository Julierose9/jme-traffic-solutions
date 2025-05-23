<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blacklist Status - JME Traffic Violation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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

        .sidebar nav a,
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

        .sidebar nav a i {
            margin-right: 0.75rem; 
        }

        .sidebar nav a:hover,
        .sidebar nav a.active,
        .dropdown-btn:hover {
            background-color: #102a5a; 
        }

        .dropdown {
            display: none;
            flex-direction: column;
            padding-left: 1.5rem;
        }

        .dropdown a {
            padding: 0.5rem 1.5rem; 
            font-size: 0.9rem;
            color: #ffffff; 
            text-decoration: none;
        }

        .main-content {
            margin-left: 18rem; 
            padding: 2rem;
        }

        .table {
            margin-top: 2rem;
        }

        .table th, .table td {
            text-align: center;
        }

        .table th {
            background-color: #0a1f44;
            color: white;
        }

        .no-records {
            text-align: center;
            padding: 20px;
            color: #666;
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
    </style>
</head>
<body>
<div class="flex">
    <div class="sidebar">
        <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
        <nav>
            <a href="{{ route('dashboard.guest') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('violation.history') }}"><i class="fas fa-exclamation-triangle"></i> Violation History</a>
            <a href="{{ route('blacklist.status') }}" class="active"><i class="fas fa-user-slash"></i> Blacklist Status</a>
            <a href="{{ route('pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
            <a href="{{ route('support') }}" class="hover:bg-blue-800"><i class="fas fa-headset"></i> Support</a>
        </nav>
        <div class="logout-btn">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <h1 class="text-2xl font-bold">Blacklist Status</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('blacklist.status') }}" class="mb-4">
            <div class="input-group w-50">
                <input type="text" name="plate_number" class="form-control" placeholder="Enter Plate Number" value="{{ request('plate_number') }}" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Check Status</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($blacklistStatus->isEmpty())
    <div class="no-records">
        <h2>No Blacklist Records Found</h2>
        @if(request('plate_number'))
            <p>The vehicle with plate number {{ request('plate_number') }} is not blacklisted or does not belong to you.</p>
        @else
            <p>You have no blacklisted vehicles. Enter a plate number to check specific vehicle status.</p>
        @endif
    </div>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Plate Number</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blacklistStatus as $status)
                <tr>
                    <td>{{ $status->registeredVehicle ? $status->registeredVehicle->plate_number : 'N/A' }}</td>
                    <td>{{ $status->status }}</td>
                    <td>{{ $status->reason }}</td>
                    <td>{{ $status->date_added }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
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