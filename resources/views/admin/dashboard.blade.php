<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Admin</title>
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
                <a href="{{ route('dashboard.admin') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('register.vehicle') }}"><i class="fas fa-car"></i> Register a Vehicle</a>
                <a href="{{ route('violation.record') }}"><i class="fas fa-exclamation-triangle"></i> Violation Records</a>
                <a href="{{ route('blacklist.management') }}"><i class="fas fa-ban"></i> Blacklist Management</a>
                <a href="{{ route('admin.pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-custom"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>Dashboard</h1>
            <div class="stats-grid">
                <div class="stats-card">
                    <h2>PENDING PAYMENTS</h2>
                    <p>{{App\Models\ViolationRecord::where('status', 'unpaid')->count() + App\Models\Report::where('status', 'pending')->count()}}</p>
                </div>
                <div class="stats-card">
                    <h2>TOTAL VIOLATIONS</h2>
                    <p>{{App\Models\ViolationRecord::count() + App\Models\Report::count()}}</p>
                </div>
                <div class="stats-card">
                    <h2>REGISTERED VEHICLES</h2>
                    <p>{{App\Models\RegisteredVehicle::count()}}</p>
                </div>
                <div class="stats-card">
                    <h2>BLACKLISTED VEHICLES</h2>
                    <p>{{App\Models\Blacklist::count()}}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Recent Violations</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Vehicle</th>
                                            <th>Violation Type</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(App\Models\ViolationRecord::latest()->take(5)->get() as $violation)
                                        <tr>
                                            <td>{{ $violation->vehicle->plate_number }}</td>
                                            <td>{{ $violation->violation_type }}</td>
                                            <td>{{ $violation->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $violation->status === 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($violation->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Payment Status</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Monthly Statistics</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyStatsChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <a href="{{ route('register.vehicle') }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-car"></i> Register Vehicle
                                    </a>
                                </div>
                                <div class="col-6 mb-3">
                                    <a href="{{ route('violation.record') }}" class="btn btn-danger btn-block">
                                        <i class="fas fa-exclamation-triangle"></i> Add Violation
                                    </a>
                                </div>
                                <div class="col-6 mb-3">
                                    <a href="{{ route('admin.pay.fines') }}" class="btn btn-success btn-block">
                                        <i class="fas fa-money-bill-wave"></i> Process Payment
                                    </a>
                                </div>
                                <div class="col-6 mb-3">
                                    <a href="{{ route('blacklist.management') }}" class="btn btn-dark btn-block">
                                        <i class="fas fa-ban"></i> Manage Blacklist
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Payment Status Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Unpaid', 'Pending'],
                datasets: [{
                    data: [
                        {{App\Models\ViolationRecord::where('status', 'paid')->count()}},
                        {{App\Models\ViolationRecord::where('status', 'unpaid')->count()}},
                        {{App\Models\ViolationRecord::where('status', 'pending')->count()}}
                    ],
                    backgroundColor: ['#10B981', '#EF4444', '#F59E0B']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Monthly Statistics Chart
        const monthlyCtx = document.getElementById('monthlyStatsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Violations',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: '#3B82F6',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

