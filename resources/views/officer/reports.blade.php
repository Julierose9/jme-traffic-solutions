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
        #createReportModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
        <nav>
            <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('officer.violation.issue') }}"><i class="fas fa-exclamation-triangle"></i> Violations</a>
            <a href="{{ route('reports.index') }}" class="active"><i class="fas fa-folder-open"></i> Reports</a>
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
            <h1 class="mb-4">My Reports</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <button class="btn" onclick="openCreateReportModal()">Create Report</button>

            <table class="table table-bordered" id="reportTable">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Violation</th>
                        <th>Vehicle</th>
                        <th>Owner</th>
                        <th>Report Date</th>
                        <th>Location</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->report_id }}</td>
                            <td>{{ $report->violation->violation_code }} - {{ $report->violation->description }}</td>
                            <td>{{ $report->vehicle->plate_number }}</td>
                            <td>{{ $report->owner->fname }} {{ $report->owner->lname }}</td>
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->location }}</td>
                            <td>{{ $report->report_details }}</td>
                            <td>{{ ucfirst($report->status) }}</td>
                            <td>
                                <a href="{{ route('reports.edit', $report->report_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="createReportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateReportModal()">×</span>
            <h2>Create Report</h2>
            <form id="reportForm" action="{{ route('reports.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="violation_id">Violation:</label>
                    <select class="form-control" id="violation_id" name="violation_id" required>
                        <option value="" disabled selected>Select Violation</option>
                        @foreach(\App\Models\Violation::all() as $violation)
                            <option value="{{ $violation->violation_id }}">{{ $violation->violation_code }} - {{ $violation->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="officer_id">Officer:</label>
                    <input type="text" class="form-control" id="officer_name" value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" readonly>
                    <input type="hidden" id="officer_id" name="officer_id" value="{{ Auth::user()->officer_id }}">
                </div>
                <div class="form-group">
                    <label for="own_id">Owner:</label>
                    <select class="form-control" id="own_id" name="own_id" required onchange="updateVehicleList(this.value)">
                        <option value="" disabled selected>Select Owner</option>
                        @foreach(\App\Models\Owner::all() as $owner)
                            <option value="{{ $owner->own_id }}">
                                {{ $owner->fname }} {{ $owner->lname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="reg_vehicle_id">Vehicle:</label>
                    <select class="form-control" id="reg_vehicle_id" name="reg_vehicle_id" required disabled>
                        <option value="" disabled selected>Select Owner First</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="report_date">Report Date:</label>
                    <input type="datetime-local" class="form-control" id="report_date" name="report_date" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="report_details">Report Details:</label>
                    <textarea class="form-control" id="report_details" name="report_details" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
        </div>
    </div>

    <script>
        function openCreateReportModal() {
            document.getElementById('createReportModal').style.display = 'block';
        }

        function closeCreateReportModal() {
            document.getElementById('createReportModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const reportModal = document.getElementById('createReportModal');
            if (event.target === reportModal) {
                closeCreateReportModal();
            }
        }

        function handleReportSubmit(event) {
            event.preventDefault(); // Prevent form submission from reloading the page
            const form = document.getElementById('reportForm');
            const formData = new FormData(form);
            const table = document.getElementById('reportTable').getElementsByTagName('tbody')[0];

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Use the data returned from the server to populate the table
                    const report = data.report;
                    const newRow = table.insertRow();
                    newRow.innerHTML = `
                        <td>${report.report_id}</td>
                        <td>${report.violation_id}</td>
                        <td>${report.reg_vehicle_id}</td>
                        <td>${report.own_id}</td>
                        <td>${report.report_date}</td>
                        <td>${report.location}</td>
                        <td>${report.report_details}</td>
                        <td>${report.remarks}</td>
                        <td>${report.status}</td>
                        <td>
                            <a href="/reports/${report.report_id}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/reports/${report.report_id}" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    `;

                    // Reset form and close modal
                    form.reset();
                    closeCreateReportModal();
                } else {
                    alert(data.message || 'Failed to create report');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the report.');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('reportForm').addEventListener('submit', handleReportSubmit);
        });

        function updateVehicleList(ownerId) {
            const vehicleSelect = document.getElementById('reg_vehicle_id');
            vehicleSelect.disabled = true;
            vehicleSelect.innerHTML = '<option value="" disabled selected>Loading vehicles...</option>';

            // Fetch vehicles for the selected owner
            fetch(`/api/owner/${ownerId}/vehicles`)
                .then(response => response.json())
                .then(vehicles => {
                    vehicleSelect.innerHTML = '<option value="" disabled selected>Select Vehicle</option>';
                    vehicles.forEach(vehicle => {
                        const option = document.createElement('option');
                        option.value = vehicle.reg_vehicle_id;
                        option.textContent = `${vehicle.plate_number} - ${vehicle.brand} ${vehicle.model}`;
                        vehicleSelect.appendChild(option);
                    });
                    vehicleSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    vehicleSelect.innerHTML = '<option value="" disabled selected>Error loading vehicles</option>';
                });
        }
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>