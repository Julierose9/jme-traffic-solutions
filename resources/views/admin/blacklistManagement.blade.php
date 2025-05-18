<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blacklist Management - Admin Dashboard</title>
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
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .modal-content button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #45a049;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
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
            overflow-x: auto;
        }
        .table {
            min-width: 900px;
        }
        .table th, .table td {
            white-space: nowrap;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th:nth-child(2), .table td:nth-child(2) {
            min-width: 120px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-edit-custom, .btn-delete-custom {
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Blacklist ID</th>
                            <th>Report ID</th>
                            <th>Plate Number</th>
                            <th>Owner Last Name</th>
                            <th>Owner First Name</th>
                            <th>Violation Description</th>
                            <th>Blacklist Type</th>
                            <th>Date Added</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($blacklistedVehicles->isEmpty())
                            <tr>
                                <td colspan="9" class="no-records">No blacklisted vehicles found.</td>
                            </tr>
                        @else
                            @foreach($blacklistedVehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->blacklist_id }}</td>
                                    <td>{{ $vehicle->report_id }}</td>
                                    <td>{{ $vehicle->registeredVehicle->plate_number }}</td>
                                    <td>{{ $vehicle->owner->lname }}</td>
                                    <td>{{ $vehicle->owner->fname }}</td>
                                    <td>{{ $vehicle->violation_description }}</td>
                                    <td>{{ $vehicle->blacklist_type }}</td>
                                    <td>{{ $vehicle->date_added }}</td>
                                    <td>
                                        <span class="badge {{ $vehicle->status === 'Active' ? 'badge-danger' : 'badge-success' }}">
                                            {{ $vehicle->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-edit-custom" onclick="openEditModal('{{ $vehicle->blacklist_id }}', '{{ $vehicle->reg_vehicle_id }}', '{{ $vehicle->own_id }}', '{{ $vehicle->reason }}', '{{ $vehicle->blacklist_type }}', '{{ $vehicle->status }}', '{{ $vehicle->appeal_status }}')"><i class="fas fa-edit"></i> Edit</button> <button class="btn-delete-custom" onclick="openDeleteModal('{{ $vehicle->blacklist_id }}')"><i class="fas fa-trash"></i> Delete</button>
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
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Blacklist Entry</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_reg_vehicle_id">Vehicle:</label>
                    <select name="reg_vehicle_id" id="edit_reg_vehicle_id" required>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->reg_vehicle_id }}">
                                {{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="edit_own_id">Owner:</label>
                    <select name="own_id" id="edit_own_id" required>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->own_id }}">
                                {{ $owner->lname }}, {{ $owner->fname }} {{ $owner->mname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="edit_reason">Reason:</label>
                    <input type="text" name="reason" id="edit_reason" required maxlength="255">
                </div>
                <div>
                    <label for="edit_blacklist_type">Blacklist Type:</label>
                    <select name="blacklist_type" id="edit_blacklist_type" required>
                        <option value="Violation-Based">Violation Based</option>
                        <option value="License Suspension">License Suspension</option>
                    </select>
                </div>
                <div>
                    <label for="edit_status">Status:</label>
                    <select name="status" id="edit_status" required>
                        <option value="Active">Active</option>
                        <option value="Lifted">Lifted</option>
                    </select>
                </div>
                <div>
                    <label for="edit_appeal_status">Appeal Status:</label>
                    <select name="appeal_status" id="edit_appeal_status" required>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Blacklist Entry</button>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function openEditModal(id, regVehicleId, ownId, reason, blacklistType, status, appealStatus) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // Set form action using the proper route
            form.action = `{{ url('/dashboard/admin/blacklist') }}/${id}`;

            // Set form values
            document.getElementById('edit_reg_vehicle_id').value = regVehicleId;
            document.getElementById('edit_own_id').value = ownId;
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
    </script>
</body>
</html>