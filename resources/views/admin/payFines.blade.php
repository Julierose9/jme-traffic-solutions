<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay Fines - Admin Dashboard</title>
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
            background-color: #0a1f44;
        }

        .dropdown a {
            padding-left: 3rem;
        }

        .main-content {
            margin-left: 18rem;
            padding: 2rem;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
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
                <a href="{{ route('dashboard.admin') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('register.vehicle') }}"><i class="fas fa-car"></i> Register a Vehicle</a>
                <a href="{{ route('violation.record') }}"><i class="fas fa-exclamation-triangle"></i> Violation Records</a>
                <a href="{{ route('blacklist.management') }}"><i class="fas fa-ban"></i> Blacklist Management</a>
                <a href="{{ route('admin.pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
                <a href="{{ route('license.suspension') }}"><i class="fas fa-ban"></i> License Suspension</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>Pay Fines</h1>
            <table class="table">
<<<<<<< HEAD
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Record ID</th>
                        <th>Payment Date</th>
                        <th>Payment Method</th>
                        <th>Transaction Reference</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($fines->isEmpty())
                        <tr>
                            <td colspan="6" class="no-records">No fines to pay.</td>
                        </tr>
                    @else
                        @foreach($fines as $fine)
                            <tr>
                                <td>{{ $fine->payment_id ?? 'N/A' }}</td>
                                <td>{{ $fine->record_id }}</td>
                                <td>{{ $fine->payment_date ?? 'N/A' }}</td>
                                <td>{{ $fine->payment_method ?? 'N/A' }}</td>
                                <td>{{ $fine->transaction_reference ?? 'N/A' }}</td>
                                <td>
                                    @if($fine->status === 'unpaid')
                                        <form action="{{ route('admin.pay.fines.pay', $fine->record_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn">Pay Now</button>
                                        </form>
                                    @else
                                        <span>Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
=======
    <thead>
        <tr>
            <th>Payment ID</th>
            <th>Record ID</th>
            <th>Payment Date</th>
            <th>Payment Method</th>
            <th>Transaction Reference</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($fines->isEmpty())
            <tr>
                <td colspan="6" class="no-records">No fines to pay.</td>
            </tr>
        @else
            @foreach($fines as $fine)
                <tr>
                    <td>{{ $fine->payment_id ?? 'N/A' }}</td>
                    <td>{{ $fine->record_id }}</td>
                    <td>{{ $fine->payment_date ?? 'N/A' }}</td>
                    <td>{{ $fine->payment_method ?? 'N/A' }}</td>
                    <td>{{ $fine->transaction_reference ?? 'N/A' }}</td>
                    <td>
                        @if($fine->status === 'unpaid')
                            <form action="{{ route('admin.pay.fines.pay', $fine->record_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn">Pay Now</button>
                            </form>
                        @else
                            <span>Paid</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
>>>>>>> master-copyOne
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