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

        .main-content {
            margin-left: 18rem;
            padding: 2rem;
        }

        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #0a1f44;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            display: inline-block;
        }

        .status-active {
            background-color: #ef4444;
            color: white;
        }

        .status-pending {
            background-color: #f59e0b;
            color: white;
        }

        .status-resolved {
            background-color: #10b981;
            color: white;
        }

        .report-details {
            background-color: #f8fafc;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .report-details h5 {
            color: #0a1f44;
            margin-bottom: 0.5rem;
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

        .no-records {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .no-records i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #9ca3af;
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
                <a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="main-content">
            <h1 class="text-2xl font-bold mb-4">My Blacklist Status</h1>

            @if($blacklistStatus->isEmpty())
                <div class="no-records">
                    <i class="fas fa-check-circle"></i>
                    <h2 class="text-xl font-semibold mb-2">No Active Blacklist Records</h2>
                    <p>You currently have no active blacklist records in the system.</p>
                </div>
            @else
                @foreach($blacklistStatus as $status)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold mb-0">{{ $status->vehicle }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p><strong>Type:</strong> {{ $status->type }}</p>
                                    <p><strong>Date Added:</strong> {{ $status->date_added }}</p>
                                    <p><strong>Reason:</strong> {{ $status->reason }}</p>
                                </div>
                                <div>
                                    <p><strong>Description:</strong> {{ $status->description }}</p>
                                    @if($status->report)
                                        <div class="report-details">
                                            <h5>Related Report Details</h5>
                                            <p><strong>Date:</strong> {{ $status->report['date'] }}</p>
                                            <p><strong>Location:</strong> {{ $status->report['location'] }}</p>
                                            <p><strong>Details:</strong> {{ $status->report['details'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>