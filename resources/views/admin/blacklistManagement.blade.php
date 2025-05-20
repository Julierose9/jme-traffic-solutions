<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blacklist Management - Admin</title>
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
            white-space: normal;
            word-wrap: break-word;
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
            overflow-x: visible;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 70%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #1a202c;
            font-weight: 600;
        }

        .close {
            font-size: 1.8rem;
            font-weight: 600;
            color: #4a5568;
            cursor: pointer;
            line-height: 1;
            padding: 0.5rem;
        }

        .close:hover {
            color: #1a202c;
        }

        .section {
            margin-bottom: 2rem;
        }

        .section-title {
            color: #2d3748;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .form-grid-2col {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            background-color: #fff;
            color: #1a202c;
            font-size: 0.875rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        .form-actions {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn-update {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background-color: #48bb78;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-update:hover {
            background-color: #38a169;
        }

        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
        }
        .btn-primary:hover {
            background-color: #0056b3 !important;
            border-color: #0056b3 !important;
        }
        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }
        .btn-danger:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 5px;
        }
        .modal-content form > div {
            margin-bottom: 15px;
        }
        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .modal-content select,
        .modal-content input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .btn-group form {
            margin: 0;
        }
        .btn-group .btn {
            padding: 0.25rem 0.75rem;
            line-height: 1.5;
            white-space: nowrap;
        }
        .text-center {
            text-align: center;
        }
        .edit-btn { background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-right: 5px; }
        .edit-btn:hover { background-color: #0056b3; }
        .delete-btn { background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        .delete-btn:hover { background-color: #c82333; }
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
        .table-responsive {
            overflow-x: visible;
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
            white-space: normal;
            word-wrap: break-word;
        }
        .table th {
            background-color: #0a1f44;
            color: white;
            font-weight: 600;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn-view-custom, .btn-edit-custom, .btn-delete-custom {
            white-space: nowrap;
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
            margin-right: 5px;
        }
        .btn-view-custom:hover {
            background: #22c55e;
            color: #fff;
        }
        .btn-view-custom i {
            margin-right: 8px;
            font-size: 1.2em;
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
        .btn-edit-custom i, .btn-delete-custom i {
            margin-right: 8px;
            font-size: 1.2em;
        }

        /* Add search container styles */
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
                <a href="{{ route('blacklist.management') }}" class="active"><i class="fas fa-ban"></i> Blacklist Management</a>
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
            <h1>Blacklist Management</h1>
            
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterRecords()">
                <button class="search-button" onclick="filterRecords()">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            

            <div class="table-responsive">
                <table class="table" id="blacklistTable">
                    <thead>
                        <tr>
                            <th>Plate Number</th>
                            <th>Reason</th>
                            <th>Blacklist Type</th>
                            <th>Date Added</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($blacklistedVehicles->isEmpty())
                            <tr>
                                <td colspan="6" class="no-records">No blacklisted vehicles found.</td>
                            </tr>
                        @else
                            @foreach($blacklistedVehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->registeredVehicle->plate_number }}</td>
                                    <td>{{ $vehicle->reason }}</td>
                                    <td>{{ $vehicle->blacklist_type }}</td>
                                    <td>{{ date('Y-m-d', strtotime($vehicle->date_added)) }}</td>
                                    <td>
                                        <span class="badge {{ $vehicle->status === 'Active' ? 'badge-danger' : 'badge-success' }}">
                                            {{ $vehicle->status }}
                                        </span>
                                    </td>
                                    <td class="action-buttons">
                                        <button class="btn-view-custom" onclick="openViewModal('{{ $vehicle->blacklist_id }}')">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-edit-custom" onclick="openEditModal('{{ $vehicle->blacklist_id }}', '{{ $vehicle->reg_vehicle_id }}', '{{ $vehicle->own_id }}', '{{ $vehicle->reason }}', '{{ $vehicle->blacklist_type }}', '{{ $vehicle->status }}', '{{ $vehicle->appeal_status }}', '{{ $vehicle->owner->lname }}, {{ $vehicle->owner->fname }} {{ $vehicle->owner->mname }}')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn-delete-custom" onclick="openDeleteModal('{{ $vehicle->blacklist_id }}')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add New Blacklist Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add New Blacklist Entry</h2>
            <form action="{{ route('blacklist.store') }}" method="POST">
                @csrf
                <div>
                    <label for="reg_vehicle_id">Vehicle:</label>
                    <select name="reg_vehicle_id" id="reg_vehicle_id" required>
                        <option value="">Select a vehicle</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->reg_vehicle_id }}">
                                {{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="own_id">Owner:</label>
                    <select name="own_id" id="own_id" required>
                        <option value="">Select an owner</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->own_id }}">
                                {{ $owner->lname }}, {{ $owner->fname }} {{ $owner->mname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="reason">Reason:</label>
                    <input type="text" name="reason" id="reason" required maxlength="255">
                </div>
                <div>
                    <label for="blacklist_type">Blacklist Type:</label>
                    <select name="blacklist_type" id="blacklist_type" required>
                        <option value="">Select type</option>
                        <option value="Violation-Based">Violation Based</option>
                        <option value="License Suspension">License Suspension</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Blacklist Entry</button>
            </form>
        </div>
    </div>

    <!-- Edit Blacklist Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Vehicle and Owner Details</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Owner Information Section -->
                <div class="section">
                    <h3 class="section-title">Owner Information</h3>
                    <div class="form-grid-2col">
                        <div class="form-group">
                            <label for="edit_owner">Owner:</label>
                            <input type="text" id="edit_owner" class="form-control" disabled>
                            <input type="hidden" name="own_id" id="edit_own_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_reason">Reason:</label>
                            <input type="text" name="reason" id="edit_reason" required maxlength="255">
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information Section -->
                <div class="section">
                    <h3 class="section-title">Vehicle Information</h3>
                    <div class="form-grid-2col">
                        <div class="form-group">
                            <label for="edit_reg_vehicle_id">Vehicle:</label>
                            <select name="reg_vehicle_id" id="edit_reg_vehicle_id" required>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->reg_vehicle_id }}">
                                        {{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_blacklist_type">Blacklist Type:</label>
                            <select name="blacklist_type" id="edit_blacklist_type" required>
                                <option value="Violation-Based">Violation Based</option>
                                <option value="License Suspension">License Suspension</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <select name="status" id="edit_status" required>
                                <option value="Active">Active</option>
                                <option value="Lifted">Lifted</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_appeal_status">Appeal Status:</label>
                            <select name="appeal_status" id="edit_appeal_status" required>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-update">Update Details</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Record Details</h2>
                <button type="button" class="close" onclick="closeViewModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vehicle Information Section -->
                <div class="section">
                    <h3 class="section-title">Vehicle Information</h3>
                    <div class="form-grid-2col">
                        <div class="form-group">
                            <label>Plate Number:</label>
                            <input type="text" id="viewPlateNumber" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Vehicle Type:</label>
                            <input type="text" id="viewVehicleType" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Brand:</label>
                            <input type="text" id="viewBrand" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Model:</label>
                            <input type="text" id="viewModel" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Color:</label>
                            <input type="text" id="viewColor" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Registration Date:</label>
                            <input type="text" id="viewRegistrationDate" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <!-- Owner Information Section -->
                <div class="section">
                    <h3 class="section-title">Owner Information</h3>
                    <div class="form-grid-2col">
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" id="viewOwnerLastName" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" id="viewOwnerFirstName" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Middle Name:</label>
                            <input type="text" id="viewOwnerMiddleName" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" id="viewOwnerAddress" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <!-- Violation Information Section -->
                <div class="section">
                    <h3 class="section-title">Violation Information</h3>
                    <div class="form-grid-2col">
                        <div class="form-group">
                            <label>Violation Code:</label>
                            <input type="text" id="viewViolationCode" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <input type="text" id="viewViolationDescription" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Penalty Amount:</label>
                            <input type="text" id="viewPenaltyAmount" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <input type="text" id="viewViolationStatus" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function openEditModal(id, regVehicleId, ownId, reason, blacklistType, status, appealStatus, ownerName) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // Set form action using the proper route
            form.action = `{{ url('/dashboard/admin/blacklist') }}/${id}`;

            // Set form values
            document.getElementById('edit_reg_vehicle_id').value = regVehicleId;
            document.getElementById('edit_own_id').value = ownId;
            document.getElementById('edit_owner').value = ownerName;
            document.getElementById('edit_reason').value = reason;
            document.getElementById('edit_blacklist_type').value = blacklistType;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_appeal_status').value = appealStatus;

            modal.style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function openDeleteModal(id) {
            if (confirm('Are you sure you want to remove this blacklist entry?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/blacklist/${id}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');
            if (event.target == addModal) {
                addModal.style.display = 'none';
            }
            if (event.target == editModal) {
                editModal.style.display = 'none';
            }
        }

        // Update button name
        document.getElementById('openModalBtn').onclick = function() {
            openAddModal();
        }

        // Add search functionality
        function filterRecords() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('blacklistTable');
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

        async function openViewModal(blacklistId) {
            try {
                const response = await fetch(`/dashboard/admin/blacklist/${blacklistId}/details`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch details');
                }

                const data = await response.json();
                
                // Update Violation Information
                const violationSection = document.querySelector('.form-grid:nth-child(1)');
                if (data.violation) {
                    document.getElementById('viewViolationCode').value = data.violation.violation_code;
                    document.getElementById('viewViolationDescription').value = data.violation.description;
                    document.getElementById('viewPenaltyAmount').value = typeof data.violation.penalty_amount === 'number' ? 
                        `₱${parseFloat(data.violation.penalty_amount).toFixed(2)}` : 'N/A';
                    document.getElementById('viewViolationStatus').value = data.violation.status;
                } else {
                    document.getElementById('viewViolationCode').value = 'N/A';
                    document.getElementById('viewViolationDescription').value = 'N/A';
                    document.getElementById('viewPenaltyAmount').value = 'N/A';
                    document.getElementById('viewViolationStatus').value = 'N/A';
                }

                // Update Vehicle Information
                if (data.vehicle) {
                    document.getElementById('viewPlateNumber').value = data.vehicle.plate_number || 'N/A';
                    document.getElementById('viewVehicleType').value = data.vehicle.vehicle_type || 'N/A';
                    document.getElementById('viewBrand').value = data.vehicle.brand || 'N/A';
                    document.getElementById('viewModel').value = data.vehicle.model || 'N/A';
                    document.getElementById('viewColor').value = data.vehicle.color || 'N/A';
                    document.getElementById('viewRegistrationDate').value = data.vehicle.registration_date ? 
                        new Date(data.vehicle.registration_date).toLocaleDateString() : 'N/A';
                }

                // Update Owner Information
                if (data.owner) {
                    document.getElementById('viewOwnerLastName').value = data.owner.lname || 'N/A';
                    document.getElementById('viewOwnerFirstName').value = data.owner.fname || 'N/A';
                    document.getElementById('viewOwnerMiddleName').value = data.owner.mname || 'N/A';
                    document.getElementById('viewOwnerAddress').value = data.owner.address || 'N/A';
                }

                // Show the modal
                document.getElementById('viewModal').style.display = 'block';
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to load details: ' + error.message);
            }
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }
    </script>
</body>
</html>