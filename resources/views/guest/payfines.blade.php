<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay Fines - JME Traffic Violation System</title>
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-unpaid, .status-pending {
            background-color: #ef4444;
            color: white;
        }

        .status-paid {
            background-color: #10b981;
            color: white;
        }

        .form-control-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
            width: 100%;
            border: 1px solid #d1d5db;
        }

        .form-control-sm:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
            outline: none;
        }

        .btn-success {
            background-color: #10b981;
            border-color: #059669;
            color: white;
            transition: all 0.2s;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #047857;
        }

        .table td {
            vertical-align: middle;
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
            <a href="{{ route('violation.history') }}"><i class="fas fa-exclamation-triangle"></i> Violation History</a>
            <a href="{{ route('blacklist.status') }}"><i class="fas fa-user-slash"></i> Blacklist Status</a>
            <a href="{{ route('pay.fines') }}" class="active"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
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
        <h1 class="text-2xl font-bold">Pay Fines</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($fines->isEmpty())
            <div class="no-records">
                <h2>No Unpaid Fines Found</h2>
                <p>You currently have no unpaid fines.</p>
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Violation Code</th>
                        <th>Penalty Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fines as $fine)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($fine->date)->format('M d, Y') }}</td>
                            <td>{{ $fine->vehicle }}</td>
                            <td>{{ ucfirst($fine->type) }}</td>
                            <td>{{ $fine->violation_code }}</td>
                            <td>₱{{ number_format($fine->penalty_amount, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($fine->status) }}">
                                    {{ ucfirst($fine->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('pay.fines.pay', ['id' => $fine->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <input type="date" name="payment_date" class="form-control form-control-sm" 
                                               value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <select name="payment_method" class="form-control form-control-sm" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Debit Card">Debit Card</option>
                                            <option value="GCash">GCash</option>
                                            <option value="Maya">Maya</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-money-bill-wave"></i> Pay Now
                                    </button>
                                </form>
                            </td>
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