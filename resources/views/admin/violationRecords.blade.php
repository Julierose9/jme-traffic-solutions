<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Violation Records - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
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
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
            vertical-align: middle;
        }

        .table th {
            background-color: #0a1f44;
            color: white;
            font-weight: 600;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .bg-primary {
            background-color: #0d6efd;
        }

        .bg-info {
            background-color: #0dcaf0;
        }

        .bg-success {
            background-color: #198754;
        }

        .text-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.875em;
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

        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .search-container input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 25px; 
            outline: none; 
            transition: border-color 0.3s;
        }

        .search-container input:focus {
            border-color: #4CAF50; 
        }

 .search-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 25px; 
            padding: 10px 15px;
            margin-left: 10px; 
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .search-button i {
            margin-right: 5px; 
        }

        .search-button:hover {
            background-color: #45a049; 
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

        .btn-edit-custom {
            background: #0090d0;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .btn-edit-custom:hover {
            background: #0077b6;
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

        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-delete-custom, .btn-edit-custom {
            height: 40px;
            min-width: 110px;
            font-size: 1rem;
            border-radius: 16px;
            padding: 0 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .btn-delete-custom {
            border: 2px solid #ef4444;
            background: #fff;
            color: #ef4444;
            transition: background 0.2s, color 0.2s;
        }
        .btn-delete-custom:hover {
            background: #ef4444;
            color: #fff;
        }
        .btn-edit-custom {
            background: #0090d0;
            color: #fff;
            border: none;
            transition: background 0.2s, color 0.2s;
        }
        .btn-edit-custom:hover {
            background: #0077b6;
            color: #fff;
        }
        .btn-delete-custom i, .btn-edit-custom i {
            margin-right: 8px;
            font-size: 1.2em;
        }

        .btn-view-custom {
            border: 2px solid #22c55e;
            background: #fff;
            color: #22c55e;
            height: 35px;
            min-width: 90px;
            font-size: 0.9rem;
            border-radius: 12px;
            padding: 0 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
        }
        .btn-view-custom:hover {
            background: #22c55e;
            color: #fff;
        }
        .btn-view-custom i {
            margin-right: 8px;
            font-size: 1.2em;
        }
        .section-title {
            color: #0a1f44;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #edf2f7;
        }
        .details-table {
            margin-bottom: 0;
        }
        .details-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            padding: 1rem;
            border-bottom: 2px solid #edf2f7;
        }
        .modal-header .close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
        }
        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a202c;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
        }

        .form-grid .section-title {
            grid-column: 1 / -1;
            color: #0a1f44;
            font-weight: 600;
            margin: 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #edf2f7;
        }

        .form-grid .form-group {
            margin-bottom: 0;
        }

        .form-grid label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #4a5568;
        }

        .form-grid input {
            width: 100%;
            padding: 8px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .form-grid input:disabled {
            background-color: #f8f9fa;
            color: #4a5568;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
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
                <a href="{{ route('violation.record') }}" class="active"><i class="fas fa-exclamation-triangle"></i> Violation Records</a>
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
            <h1>Violation Records</h1>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterRecords()">
                <button class="search-button" onclick="filterRecords()">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <table class="table" id="recordsTable">
                <thead>
                    <tr>
                        <th>Violation Code</th>
                        <th>Description</th>
                        <th>Penalty Amount</th>
                        <th>Plate Number</th>
                        <th>Violation Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($allRecords->isEmpty())
                        <tr>
                            <td colspan="7" class="no-records">No records found.</td>
                        </tr>
                    @else
                        @foreach($allRecords as $record)
                                <tr>
                                <td>{{ $record->violation_code }}</td>
                                <td>{{ $record->description }}</td>
                                <td>₱{{ number_format($record->penalty_amount, 2) }}</td>
                                <td>{{ $record->plate_number }}</td>
                                <td>{{ $record->violation_date ? date('Y-m-d', strtotime($record->violation_date)) : '' }}</td>
                                <td>{{ $record->status }}</td>
                                    <td>
                                    <button class="btn-view-custom" onclick="openRecordDetailsModal('{{ $record->id }}')">
                                        <i class="fas fa-eye"></i> View
                                            </button>
                                    </td>
                                </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Modal for Record Details -->
            <div class="modal fade" id="recordDetailsModal" tabindex="-1" role="dialog" aria-labelledby="recordDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Record Details</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Vehicle Information Section -->
                            <div class="form-grid">
                                <h3 class="section-title">Vehicle Information</h3>
                                <div class="form-group">
                                    <label>Plate Number:</label>
                                    <input type="text" id="vehiclePlateNumber" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Vehicle Type:</label>
                                    <input type="text" id="vehicleType" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Brand:</label>
                                    <input type="text" id="vehicleBrand" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Model:</label>
                                    <input type="text" id="vehicleModel" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Color:</label>
                                    <input type="text" id="vehicleColor" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Registration Date:</label>
                                    <input type="text" id="registrationDate" class="form-control" disabled>
                                </div>
                            </div>

                            <!-- Officer Information Section -->
                            <div class="form-grid">
                                <h3 class="section-title">Officer Information</h3>
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" id="officerLastName" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" id="officerFirstName" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                async function openRecordDetailsModal(recordId) {
                    try {
                        // Find the record in the table
                        const rows = document.querySelectorAll('#recordsTable tbody tr');
                        let record = null;
                        
                        for (let row of rows) {
                            const cells = row.getElementsByTagName('td');
                            if (cells[3]) { // plate number cell
                                const plateNumber = cells[3].textContent;
                                const allRecords = @json($allRecords);
                                record = allRecords.find(r => r.plate_number === plateNumber && (r.id == recordId || r.id === 'R-' + recordId));
                                if (record) break;
                            }
                        }

                        if (!record) {
                            throw new Error('Record not found');
                        }

                        // Update vehicle information
                        if (record.vehicle) {
                            document.getElementById('vehiclePlateNumber').value = record.plate_number || 'N/A';
                            document.getElementById('vehicleType').value = record.vehicle.vehicle_type || 'N/A';
                            document.getElementById('vehicleBrand').value = record.vehicle.brand || 'N/A';
                            document.getElementById('vehicleModel').value = record.vehicle.model || 'N/A';
                            document.getElementById('vehicleColor').value = record.vehicle.color || 'N/A';
                            document.getElementById('registrationDate').value = record.vehicle.registration_date || 'N/A';
                        }

                        // Update officer information
                        if (record.officer) {
                            document.getElementById('officerLastName').value = record.officer.last_name || 'N/A';
                            document.getElementById('officerFirstName').value = record.officer.first_name || 'N/A';
                        }

                        // Show the modal
                        $('#recordDetailsModal').modal('show');
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Failed to load record details: ' + error.message);
                    }
                }

                // Close modal when clicking the close button or outside
                $(document).ready(function() {
                    $('.close').on('click', function() {
                        $('#recordDetailsModal').modal('hide');
                    });

                    $('#recordDetailsModal').on('hidden.bs.modal', function () {
                        // Clear form fields when modal is closed
                        const inputs = document.querySelectorAll('#recordDetailsModal input');
                        inputs.forEach(input => input.value = '');
                    });
                });

                function filterRecords() {
                    const input = document.getElementById('searchInput');
                    const filter = input.value.toLowerCase();
                    const table = document.getElementById('recordsTable');
                    const tr = table.getElementsByTagName('tr');

                    for (let i = 1; i < tr.length; i++) {
                        const row = tr[i];
                        const cells = row.getElementsByTagName('td');
                        let found = false;
                        
                        for (let j = 0; j < cells.length; j++) {
                            const cell = cells[j];
                            if (cell) {
                                const text = cell.textContent || cell.innerText;
                                if (text.toLowerCase().indexOf(filter) > -1) {
                                    found = true;
                                    break;
                                }
                            }
                        }
                        
                        row.style.display = found ? '' : 'none';
                    }
                }
            </script>
        </div>
    </div>
</body>
</html>