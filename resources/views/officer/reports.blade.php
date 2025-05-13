<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reports - Officer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
        .modal-header {
            background-color: #0a1f44;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
        <nav>
<<<<<<< HEAD
            <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
=======
        <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
>>>>>>> master-copyOne
            <a href="{{ route('officer.violation.issue') }}"id="sidebarOpenModalBtn" data-toggle="modal" data-target="#generateViolationModal"><i class="fas fa-exclamation-triangle"></i> Issue Violation</a>
            <a href="{{ route('reports.index') }} "class="active"><i class="fas fa-folder-open"></i> Reports</a>
        </nav>
        <div class="logout-btn">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="container mt-5">
            <h1 class="mb-4">Reports</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <button class="btn" data-toggle="modal" data-target="#createReportModal">Create Report</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Report ID</th>
            <th>Violation ID</th>
            <th>Officer ID</th>
            <th>Vehicle ID</th>
            <th>Owner ID</th>
            <th>Report Details</th>
            <th>Location</th>
            <th>Report Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
            <tr>
                <td>{{ $report->report_id }}</td>
                <td>{{ $report->violation_id }}</td>
                <td>{{ $report->officer_id }}</td>
                <td>{{ $report->reg_vehicle_id }}</td>
                <td>{{ $report->own_id }}</td>
                <td>{{ $report->report_details }}</td>
                <td>{{ $report->location }}</td>
                <td>{{ $report->report_date }}</td>
                <td>{{ $report->status }}</td>
                <td>
                    <a href="{{ route('reports.edit', $report->report_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>


<div class="modal fade" id="createReportModal" tabindex="-1" role="dialog" aria-labelledby="createReportModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="createReportModalLabel">Create Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="violation_id">Violation ID</label>
                <input type="text" class="form-control" id="violation_id" name="violation_id" required>
            </div>
            <div class="form-group">
                <label for="officer_id">Officer ID</label>
                <input type="text" class="form-control" id="officer_id" name="officer_id" required>
            </div>
            <div class="form-group">
                <label for="reg_vehicle_id">Vehicle ID</label>
                <input type="text" class="form-control" id="reg_vehicle_id" name="reg_vehicle_id" required>
            </div>
            <div class="form-group">
                <label for="own_id">Owner ID</label>
                <input type="text" class="form-control" id="own_id" name="own_id" required>
            </div>
            <div class="form-group">
                <label for="report_details">Report Details</label>
                <textarea class="form-control" id="report_details" name="report_details" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="report_date">Report Date</label>
                <input type="date" class="form-control" id="report_date" name="report_date" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create Report</button>
        </div>
    </form>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT+z0j3+0I4z5+5z5+5z5+5z5+5z5+5z5+5z5+5z5+5z5+5z5" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-JZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZyZ
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></script>
</body>
</html>