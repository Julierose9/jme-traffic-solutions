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
    <!-- Add Select2 for enhanced dropdowns (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            transition: background-color 0.3s ease;
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
            transition: background-color 0.3s ease;
        }
        .logout-btn button:hover {
            background-color: #b22222;
        }
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            background-color: #ffffff;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-header h2 {
            font-size: 1.75rem;
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }
        .modal-header .close {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: #7f8c8d;
            opacity: 1;
            background: none;
            border: 0;
            padding: 0.75rem;
            transition: color 0.3s ease;
        }
        .modal-header .close:hover {
            color: #e74c3c;
        }
        .btn-primary {
            color: #fff;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #003d80);
            transform: translateY(-2px);
        }
        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-2px);
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow-y: auto;
            padding: 20px;
        }
        .modal-content {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 50%;
            max-width: 700px;
            margin: 5% auto;
            background-color: #ffffff;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
            padding: 1rem;
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
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #2c3e50;
            background-color: #fff;
            border: 2px solid #ced4da;
            border-radius: 0.5rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }
        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1;
            cursor: not-allowed;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            color: #34495e;
        }
        .btn-container {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
            justify-content: flex-end;
        }
        .btn {
            display: inline-block;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        #createReportModal .modal-body {
            padding: 2rem;
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
            background-color: rgba(0,0,0,0.5);
            padding: 20px;
        }
        .close {
            color: #7f8c8d;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .close:hover,
        .close:focus {
            color: #e74c3c;
            text-decoration: none;
            cursor: pointer;
        }
        textarea.form-control {
            height: auto;
            min-height: 100px;
            resize: vertical;
        }
        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
        }
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
        /* Loading Spinner for Submit Button */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        .btn-loading:after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @media (max-width: 768px) {
            .modal-content {
                width: 90%;
                margin: 10% auto;
            }
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
            <div class="modal-header">
                <h2>Create New Report</h2>
            </div>
            <div class="modal-body">
                <form id="reportForm" action="{{ route('reports.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="violation_id">Violation:</label>
                        <select class="form-control" id="violation_id" name="violation_id" required>
                            <option value="" disabled selected>Select Violation</option>
                            @foreach(\App\Models\Violation::all() as $violation)
                                <option value="{{ $violation->violation_id }}">{{ $violation->violation_code }} - {{ $violation->description }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a violation.</div>
                    </div>
                    <div class="form-group">
                        <label for="officer_name">Officer:</label>
                        <input type="text" class="form-control" id="officer_name" value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="own_id">Owner:</label>
                        <select class="form-control" id="own_id" name="own_id" required onchange="updateVehicleList(this.value)">
                            <option value="" disabled selected>Select Owner</option>
                            @foreach(\App\Models\Owner::whereHas('registeredVehicles')
                                ->whereNotNull('fname')
                                ->whereNotNull('lname')
                                ->get() as $owner)
                                <option value="{{ $owner->own_id }}">
                                    {{ $owner->fname }} {{ $owner->lname }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select an owner.</div>
                    </div>
                    <div class="form-group">
                        <label for="reg_vehicle_id">Vehicle:</label>
                        <select class="form-control" id="reg_vehicle_id" name="reg_vehicle_id" required disabled>
                            <option value="" disabled selected>Select Owner First</option>
                        </select>
                        <div class="invalid-feedback">Please select a vehicle.</div>
                    </div>
                    <div class="form-group">
                        <label for="report_date">Report Date:</label>
                        <input type="date" class="form-control" id="report_date" name="report_date" value="{{ now()->format('Y-m-d') }}" required>
                        <div class="invalid-feedback">Please enter a report date.</div>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                        <div class="invalid-feedback">Please enter a location.</div>
                    </div>
                    <div class="form-group">
                        <label for="report_details">Report Details:</label>
                        <textarea class="form-control" id="report_details" name="report_details" rows="4" required></textarea>
                        <div class="invalid-feedback">Please enter report details.</div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary" id="submitButton">
                            Submit Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeCreateReportModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editReportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Report</h2>
                <button type="button" class="close" onclick="closeEditReportModal()">×</button>
            </div>
            <div class="modal-body">
                <form id="editReportForm" method="POST">
                    @csrf
                    @method('PUT')
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
                        <textarea class="form-control" id="edit_report_details" name="report_details" rows="4" required></textarea>
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
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Add Select2 for enhanced dropdowns (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Set baseUrl for API requests
        const baseUrl = "{{ url('/') }}";

        function openCreateReportModal() {
            document.getElementById('createReportModal').style.display = 'block';
            // Initialize Select2 on dropdowns
            $('#violation_id, #own_id, #reg_vehicle_id').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
        }

        function resetCreateReportForm() {
            const form = document.getElementById('reportForm');
            form.reset();
            const vehicleSelect = document.getElementById('reg_vehicle_id');
            vehicleSelect.innerHTML = '<option value="" disabled selected>Select Owner First</option>';
            vehicleSelect.disabled = true;
            // Destroy and reinitialize Select2 to reset
            $('#violation_id, #own_id, #reg_vehicle_id').select2('destroy').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
        }

        function closeCreateReportModal() {
            document.getElementById('createReportModal').style.display = 'none';
            resetCreateReportForm();
        }

        function openEditReportModal(reportId) {
            const modal = document.getElementById('editReportModal');
            const form = document.getElementById('editReportForm');
            modal.style.display = 'block';
            form.action = `${baseUrl}/dashboard/reports/${reportId}`;

            // Initialize Select2 for status dropdown
            $('#edit_status').select2({
                placeholder: "Select a status",
                allowClear: true,
                width: '100%'
            });

            fetch(`${baseUrl}/dashboard/reports/${reportId}/edit`, {
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
                document.getElementById('edit_own_id').value = data.own_id;
                document.getElementById('edit_owner_name').value = `${data.owner.fname} ${data.owner.lname}`;
                document.getElementById('edit_reg_vehicle_id').value = data.reg_vehicle_id;
                document.getElementById('edit_vehicle_info').value = `${data.vehicle.plate_number} - ${data.vehicle.brand} ${data.vehicle.model}`;
                // Set only the date part for the input type="date"
                document.getElementById('edit_report_date').value = data.report_date.substring(0, 10);
                document.getElementById('edit_location').value = data.location;
                document.getElementById('edit_report_details').value = data.report_details;
                // Set status and trigger change for Select2
                $('#edit_status').val(data.status).trigger('change');
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
            const submitButton = document.getElementById('submitButton');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            submitButton.classList.add('btn-loading');
            submitButton.disabled = true;

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
                    alert(data.message || 'Failed to create report');
                    submitButton.classList.remove('btn-loading');
                    submitButton.disabled = false;
                    submitButton.textContent = 'Submit Report';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the report');
                submitButton.classList.remove('btn-loading');
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Report';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
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

            fetch(`${baseUrl}/api/owner/${ownerId}/vehicles`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.error || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
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
                    $('#reg_vehicle_id').trigger('change.select2');
                } else {
                    vehicleSelect.innerHTML = '<option value="" disabled selected>No vehicles found for this owner</option>';
                    vehicleSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error fetching vehicles:', error, error.stack);
                vehicleSelect.innerHTML = '<option value="" disabled selected>Error loading vehicles: ' + error.message + '</option>';
                vehicleSelect.disabled = true;
                alert('Failed to load vehicles. Please check the console for details or try again later.');
            });
        }

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
</body>
</html>