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
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            background-color: #fff;
            border-top-left-radius: 0.3rem;
            border-top-right-radius: 0.3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modal-header h2 {
            font-size: 1.5rem;
            margin: 0;
            color: #333;
            font-weight: 500;
        }

        .modal-header .close {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
            color: #000;
            opacity: .5;
            background: none;
            border: 0;
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: #fff;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.2s ease-in-out;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: #fff;
        }

        .table .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .table .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .table .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .table .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .table .btn-danger:hover {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Remove any existing hover effects that might turn buttons green */
        .btn:hover {
            opacity: 1;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(169, 169, 169, 0.5);
            overflow-y: auto;
            padding: 20px;
        }

        .modal-content {
            border-radius: 0.3rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 40%;
            margin: 5% auto;
            max-width: 600px;
            background-color: #fff;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(169, 169, 169, 0.5);
            z-index: 1040;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1;
            cursor: not-allowed;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #212529;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-container {
            display: flex;
            gap: 0.5rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #dee2e6;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        #createReportModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            background-color: rgba(0,0,0,0.4);
            padding: 20px;
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
        .form-group {
            margin-bottom: 15px;
        }
        textarea.form-control {
            height: auto;
            min-height: 80px;
        }
        /* Fix for modal scrolling */
        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
        }
        /* Make sure inputs are not disabled or readonly */
        input:not([type="submit"]):not([readonly]),
        textarea:not([readonly]),
        select:not([disabled]) {
            background-color: #fff !important;
            cursor: text !important;
            pointer-events: auto !important;
            opacity: 1 !important;
        }
        .container {
            padding: 1rem;
        }
        .table td .btn {
            margin-right: 5px;
        }

        .table td form {
            margin: 0;
            padding: 0;
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
                            <td>{{ $report->violation->violation_code }}</td>
                            <td>{{ $report->vehicle->plate_number }}</td>
                            <td>{{ $report->owner->fname }} {{ $report->owner->lname }}</td>
                            <td>{{ $report->report_date->format('Y-m-d') }}</td>
                            <td>{{ $report->location }}</td>
                            <td>{{ $report->report_details }}</td>
                            <td>{{ ucfirst($report->status) }}</td>
                            <td>
                                <button onclick="openEditReportModal({{ $report->report_id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
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
                    <label for="officer_name">Officer:</label>
                    <input type="text" class="form-control" id="officer_name" value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" readonly>
                </div>
                <div class="form-group">
                    <label for="own_id">Owner:</label>
                    <select class="form-control" id="own_id" name="own_id" required onchange="updateVehicleList(this.value)">
                        <option value="" disabled selected>Select Owner</option>
                        @foreach(\App\Models\Owner::whereHas('registeredVehicles')->get() as $owner)
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
                    <input type="date" class="form-control" id="report_date" name="report_date" required>
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

    <div id="editReportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Vehicle and Owner Details</h2>
                <button type="button" class="close" onclick="closeEditReportModal()">&times;</button>
            </div>
            <form id="editReportForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="section-title">Owner Information</div>
                    <div class="form-group">
                        <label for="edit_owner_name">Owner:</label>
                        <input type="text" class="form-control" id="edit_owner_name" disabled>
                        <input type="hidden" id="edit_own_id" name="own_id">
                    </div>

                    <div class="form-group">
                        <label for="edit_vehicle_info">Vehicle:</label>
                        <input type="text" class="form-control" id="edit_vehicle_info" disabled>
                        <input type="hidden" id="edit_reg_vehicle_id" name="reg_vehicle_id">
                    </div>

                    <div class="section-title">Report Information</div>
                    <div class="form-group">
                        <label for="edit_report_date">Report Date:</label>
                        <input type="date" class="form-control" id="edit_report_date" name="report_date" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_location">Location:</label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_report_details">Report Details:</label>
                        <textarea class="form-control" id="edit_report_details" name="report_details" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_status">Status:</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary">Update Report</button>
                        <button type="button" class="btn btn-secondary" onclick="closeEditReportModal()">Cancel</button>
                    </div>
                </div>
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

        function openEditReportModal(reportId) {
            const modal = document.getElementById('editReportModal');
            const form = document.getElementById('editReportForm');
            modal.style.display = 'block';
            
            // Set the form action
            form.action = `/dashboard/reports/${reportId}`;

            // Fetch report data
            fetch(`/dashboard/reports/${reportId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch report data');
                }
                return response.json();
            })
            .then(data => {
                // Populate form fields
                document.getElementById('edit_own_id').value = data.own_id;
                document.getElementById('edit_owner_name').value = `${data.owner.fname} ${data.owner.lname}`;
                document.getElementById('edit_reg_vehicle_id').value = data.reg_vehicle_id;
                document.getElementById('edit_vehicle_info').value = `${data.vehicle.plate_number} - ${data.vehicle.brand} ${data.vehicle.model}`;
                document.getElementById('edit_report_date').value = data.report_date;
                document.getElementById('edit_location').value = data.location;
                document.getElementById('edit_report_details').value = data.report_details;
                document.getElementById('edit_status').value = data.status;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading report data');
                closeEditReportModal();
            });
        }

        function closeEditReportModal() {
            document.getElementById('editReportModal').style.display = 'none';
        }

        function handleReportSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('reportForm');
            const formData = new FormData(form);

            // Convert FormData to JSON
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to create report');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the report');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add form submission handler for edit form
            document.getElementById('editReportForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to update report');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the report');
                });
            });

            document.getElementById('reportForm').addEventListener('submit', handleReportSubmit);
            document.getElementById('location').removeAttribute('readonly');
            document.getElementById('report_details').removeAttribute('readonly');
        });

        function updateVehicleList(ownerId) {
            const vehicleSelect = document.getElementById('reg_vehicle_id');
            vehicleSelect.disabled = true;
            vehicleSelect.innerHTML = '<option value="" disabled selected>Loading vehicles...</option>';

            // Fetch vehicles for the selected owner
            fetch(`/api/owner/${ownerId}/vehicles`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include' // Include cookies in the request
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json().then(data => {
                    console.log('Response data:', data);
                    if (!response.ok) {
                        throw new Error(data.error || `HTTP error! status: ${response.status}`);
                    }
                    return data;
                });
            })
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    vehicleSelect.innerHTML = '<option value="" disabled selected>Select Vehicle</option>';
                    data.forEach(vehicle => {
                        const option = document.createElement('option');
                        option.value = vehicle.reg_vehicle_id;
                        option.textContent = `${vehicle.plate_number} - ${vehicle.brand} ${vehicle.model} (${vehicle.vehicle_type})`;
                        vehicleSelect.appendChild(option);
                    });
                    vehicleSelect.disabled = false;
                } else if (data.message) {
                    vehicleSelect.innerHTML = `<option value="" disabled selected>${data.message}</option>`;
                    vehicleSelect.disabled = true;
                } else {
                    vehicleSelect.innerHTML = '<option value="" disabled selected>No vehicles found for this owner</option>';
                    vehicleSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                vehicleSelect.innerHTML = '<option value="" disabled selected>Error loading vehicles. Please try again.</option>';
                vehicleSelect.disabled = true;
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const createModal = document.getElementById('createReportModal');
            const editModal = document.getElementById('editReportModal');
            if (event.target === createModal) {
                closeCreateReportModal();
            } else if (event.target === editModal) {
                closeEditReportModal();
            }
        }
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>