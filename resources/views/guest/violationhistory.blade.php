<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Violation History - Guest Dashboard</title>
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
            overflow-y: auto;
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

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on mobile */
        }

        .table {
            width: 100%;
            min-width: 600px; /* Minimum width to ensure scrollability */
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
            white-space: nowrap; /* Prevents text wrapping, creating a single-line effect */
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-paid {
            background-color: #10b981;
            color: white;
        }

        .status-unpaid {
            background-color: #ef4444;
            color: white;
        }

        .btn-success {
            background-color: #10b981;
            border-color: #059669;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #047857;
            color: white;
        }

        .btn-info {
            background-color: #3b82f6;
            border-color: #2563eb;
            color: white;
        }

        .btn-info:hover {
            background-color: #2563eb;
            border-color: #1d4ed8;
            color: white;
        }

        .btn i {
            margin-right: 5px;
        }

        .d-inline {
            display: inline-block;
            margin-right: 5px;
        }

        .btn-delete-custom {
            border: 2px solid #ef4444;
            background: #fff;
            color: #ef4444;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .btn-delete-custom:hover {
            background: #ef4444;
            color: #fff;
        }

        .btn-logout-custom {
            border: 2px solid #ef4444;
            background: #fff;
            color: #ef4444;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .btn-logout-custom:hover {
            background: #ef4444;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ route('dashboard.guest') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('violation.history') }}" class="active"><i class="fas fa-history"></i> Violation History</a>
                <a href="{{ route('blacklist.status') }}"><i class="fas fa-user-slash"></i> Blacklist Status</a>
                <a href="{{ route('pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
                <a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-custom"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>My Violation History</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vehicle</th>
                            <th>Violation</th>
                            <th>Location</th>
                            <th>Officer</th>
                            <th>Penalty Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($allRecords->isEmpty())
                            <tr>
                                <td colspan="8" class="no-records">No records found.</td>
                            </tr>
                        @else
                            @foreach($allRecords as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                                    <td>{{ $record->vehicle }}</td>
                                    <td>{{ $record->violation }}</td>
                                    <td>{{ $record->location }}</td>
                                    <td>{{ $record->officer }}</td>
                                    <td>₱{{ number_format($record->penalty_amount, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($record->status) }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($record->status == 'pending' || $record->status == 'unpaid')
                                            <a href="{{ route('pay.fines') }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-money-bill-wave"></i> Pay Now
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>