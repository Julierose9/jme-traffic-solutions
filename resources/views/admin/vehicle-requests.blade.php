<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vehicle Registration Requests - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <style>
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
        .main-content {
            margin-left: 18rem;
            padding: 2rem;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-approved {
            background-color: #28a745;
            color: #fff;
        }
        .badge-rejected {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-group {
            gap: 0.5rem;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
        .btn-approve:hover, .btn-reject:hover {
            color: white;
            opacity: 0.9;
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
                <a href="{{ route('admin.vehicle.requests') }}" class="active"><i class="fas fa-clipboard-list"></i> Vehicle Requests</a>
            </nav>
        </div>

        <div class="main-content">
            <h1 class="mb-4">Vehicle Registration Requests</h1>

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

            <div class="row">
                @forelse($requests as $request)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Request #{{ $request->id }}</h5>
                                <span class="badge badge-{{ $request->status === 'pending' ? 'pending' : ($request->status === 'approved' ? 'approved' : 'rejected') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Requester:</strong><br>
                                        {{ $request->user->lname }}, {{ $request->user->fname }} {{ $request->user->mname }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Date Requested:</strong><br>
                                        {{ $request->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>

                                <h6 class="mb-3">Vehicle Details:</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="30%">Vehicle Type:</th>
                                        <td>{{ $request->vehicle_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand:</th>
                                        <td>{{ $request->brand }}</td>
                                    </tr>
                                    <tr>
                                        <th>Model:</th>
                                        <td>{{ $request->model }}</td>
                                    </tr>
                                    <tr>
                                        <th>Plate Number:</th>
                                        <td>{{ $request->plate_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Color:</th>
                                        <td>{{ $request->color }}</td>
                                    </tr>
                                    @if($request->notes)
                                    <tr>
                                        <th>Notes:</th>
                                        <td>{{ $request->notes }}</td>
                                    </tr>
                                    @endif
                                </table>

                                @if($request->status === 'pending')
                                    <div class="d-flex justify-content-end mt-3 btn-group">
                                        <button class="btn btn-approve" onclick="approveRequest({{ $request->id }})">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button class="btn btn-reject" onclick="rejectRequest({{ $request->id }})">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No vehicle registration requests found.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function approveRequest(requestId) {
            if (confirm('Are you sure you want to approve this request?')) {
                fetch(`/vehicle-registration-requests/${requestId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Request approved successfully!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to approve request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while approving the request');
                });
            }
        }

        function rejectRequest(requestId) {
            if (confirm('Are you sure you want to reject this request?')) {
                fetch(`/vehicle-registration-requests/${requestId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Request rejected successfully!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to reject request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while rejecting the request');
                });
            }
        }
    </script>
</body>
</html> 