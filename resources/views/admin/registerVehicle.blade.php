<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register Vehicle - Admin Dashboard</title>
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

        .modal {
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
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        form div {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input,
        form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        form input:focus,
        form select:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        form button:hover {
            background-color: #45a049;
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

        .action-buttons button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .action-buttons .edit-btn {
            background-color: #2563eb;
            color: white;
        }

        .action-buttons .edit-btn:hover {
            background-color: #1d4ed8;
        }

        .action-buttons .delete-btn {
            background-color: #dc2626;
            color: white;
        }

        .action-buttons .delete-btn:hover {
            background-color: #b91c1c;
        }

        .alert-success {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-success .close-alert {
            cursor: pointer;
            font-size: 20px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0a1f44;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #edf2f7;
        }

        .request-card {
            margin-bottom: 1.5rem;
        }
        .badge {
            padding: 0.5em 1em;
            border-radius: 20px;
            font-weight: 500;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        .badge-success {
            background-color: #28a745;
            color: #fff;
        }
        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-link {
            color: #0a1f44;
            padding: 0.25rem 0.5rem;
            text-decoration: none;
            border: none;
            background: none;
        }
        
        .btn-link:hover {
            color: #1a3f84;
        }

        .btn-link:focus {
            outline: none;
            box-shadow: none;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .collapsed {
            display: none;
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
                <a href="{{route('blacklist.management')}}"><i class="fas fa-ban"></i> Blacklist Management</a>
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
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                    <span class="close-alert" onclick="this.parentElement.style.display='none'">&times;</span>
                </div>
            @endif

            <div class="mb-4">
                <h1>Vehicle Registration Management</h1>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" onclick="openVehicleModal()">Register a New Vehicle</button>
                </div>
            </div>

            <!-- Vehicle Registration Requests Section -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Pending Registration Requests</h2>
                    <button class="btn btn-link" onclick="toggleRequestsSection()" id="toggleRequestsBtn">
                        <i class="fas fa-minus" id="toggleIcon"></i>
                    </button>
                </div>
                <div class="card-body" id="requestsSection">
                    @forelse($requests as $request)
                        <div class="request-card mb-3">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Request #{{ $request->id }}</h5>
                                    <span class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
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
                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-success mr-2" onclick="approveRequest({{ $request->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger" onclick="rejectRequest({{ $request->id }})">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            No pending vehicle registration requests.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Registered Vehicles Table -->
            <div class="card">
                <div class="card-header">
                    <h2>Registered Vehicles</h2>
                </div>
                <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vehicle ID</th>
                        <th>Owner ID</th>
                        <th>Plate Number</th>
                        <th>Vehicle Type</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registeredVehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->reg_vehicle_id }}</td>
                        <td>{{ $vehicle->own_id }}</td>
                        <td>{{ $vehicle->plate_number }}</td>
                        <td>{{ $vehicle->vehicle_type }}</td>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->color }}</td>
                        <td>{{ $vehicle->registration_date }}</td>
                        <td class="action-buttons">
                            <button class="edit-btn" onclick="openEditVehicleModal('{{ $vehicle->reg_vehicle_id }}')"><i class="fas fa-edit"></i> Edit</button>
                            <button class="delete-btn" onclick="openDeleteVehicleModal('{{ $vehicle->reg_vehicle_id }}')"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>

    <div id="registerVehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeVehicleModal()">×</span>
            <h2>Register a Vehicle</h2>
            <form id="registerVehicleForm" method="POST" action="{{ route('register.vehicle.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="user_id">Guest Name:</label>
                    <select name="user_id" id="user_id" required class="form-control">
                        <option value="" disabled selected>Select Guest</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->lname }}, {{ $user->fname }} {{ $user->mname ? $user->mname : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="contact_num">Contact Number:</label>
                    <input type="text" id="contact_num" name="contact_num" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="license_number">License Number:</label>
                    <input type="text" id="license_number" name="license_number" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="plate_number">Plate Number:</label>
                    <input type="text" id="plate_number" name="plate_number" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="vehicle_type">Vehicle Type:</label>
                    <select id="vehicle_type" name="vehicle_type" required class="form-control">
                        <option value="" disabled selected>Select Vehicle Type</option>
                        <option value="Car">Car</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Truck">Truck</option>
                        <option value="Van">Van</option>
                        <option value="SUV">SUV</option>
                        <option value="Bus">Bus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <select id="brand" name="brand" required class="form-control">
                        <option value="" disabled selected>Select Brand</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Honda">Honda</option>
                        <option value="Ford">Ford</option>
                        <option value="BMW">BMW</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Tesla">Tesla</option>
                        <option value="Yamaha">Yamaha</option>
                        <option value="Suzuki">Suzuki</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="model">Model:</label>
                    <select id="model" name="model" required class="form-control">
                        <option value="" disabled selected>Select Model</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color">Color:</label>
                    <select id="color" name="color" required class="form-control">
                        <option value="" disabled selected>Select Color</option>
                        <option value="Black">Black</option>
                        <option value="White">White</option>
                        <option value="Silver">Silver</option>
                        <option value="Red">Red</option>
                        <option value="Blue">Blue</option>
                        <option value="Gray">Gray</option>
                        <option value="Green">Green</option>
                        <option value="Yellow">Yellow</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="registration_date">Registration Date:</label>
                    <input type="date" id="registration_date" name="registration_date" required class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Register Vehicle</button>
            </form>
        </div>
    </div>

    <div id="editVehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditVehicleModal()">×</span>
            <h2>Edit Vehicle and Owner Details</h2>
            <form id="editVehicleForm" method="POST" action="{{ route('edit.vehicle.submit') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_vehicle_id" name="reg_vehicle_id">
                
                <h3 class="section-title">Owner Information</h3>
                <div class="form-group">
                    <label for="edit_owner_name">Owner:</label>
                    <input type="text" id="edit_owner_name" class="form-control" disabled>
                    <input type="hidden" id="edit_owner_id" name="own_id">
                </div>

                <div class="form-group">
                    <label for="edit_address">Address:</label>
                    <input type="text" id="edit_address" name="address" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_contact_num">Contact Number:</label>
                    <input type="text" id="edit_contact_num" name="contact_num" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_license_number">License Number:</label>
                    <input type="text" id="edit_license_number" name="license_number" class="form-control" required>
                </div>

                <h3 class="section-title">Vehicle Information</h3>
                <div class="form-group">
                    <label for="edit_plate_number">Plate Number:</label>
                    <input type="text" id="edit_plate_number" name="plate_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_vehicle_type">Vehicle Type:</label>
                    <select id="edit_vehicle_type" name="vehicle_type" class="form-control" required>
                        <option value="" disabled>Select Vehicle Type</option>
                        <option value="Car">Car</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Truck">Truck</option>
                        <option value="Van">Van</option>
                        <option value="SUV">SUV</option>
                        <option value="Bus">Bus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_brand">Brand:</label>
                    <select id="edit_brand" name="brand" class="form-control" required>
                        <option value="" disabled>Select Brand</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Honda">Honda</option>
                        <option value="Ford">Ford</option>
                        <option value="BMW">BMW</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Tesla">Tesla</option>
                        <option value="Yamaha">Yamaha</option>
                        <option value="Suzuki">Suzuki</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_model">Model:</label>
                    <select id="edit_model" name="model" class="form-control" required>
                        <option value="" disabled>Select Model</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_color">Color:</label>
                    <select id="edit_color" name="color" class="form-control" required>
                        <option value="" disabled>Select Color</option>
                        <option value="Black">Black</option>
                        <option value="White">White</option>
                        <option value="Silver">Silver</option>
                        <option value="Red">Red</option>
                        <option value="Blue">Blue</option>
                        <option value="Gray">Gray</option>
                        <option value="Green">Green</option>
                        <option value="Yellow">Yellow</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_registration_date">Registration Date:</label>
                    <input type="date" id="edit_registration_date" name="registration_date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Details</button>
            </form>
        </div>
    </div>

    <div id="deleteVehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteVehicleModal()">×</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this vehicle?</p>
            <form id="deleteVehicleForm" method="POST" action="{{ route('delete.vehicle.submit') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" id="delete_vehicle_id" name="reg_vehicle_id">
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" onclick="closeDeleteVehicleModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('registerVehicleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Submit the form
            fetch(this.action, {
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
                    alert('Vehicle registered successfully!');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to register vehicle');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while registering the vehicle');
            });
        });

        function openVehicleModal() {
            document.getElementById('registerVehicleModal').style.display = 'block';
        }

        function closeVehicleModal() {
            document.getElementById('registerVehicleModal').style.display = 'none';
        }

        async function openEditVehicleModal(vehicleId) {
            try {
                const response = await fetch(`/dashboard/admin/vehicles/${vehicleId}/edit`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch vehicle details');
                }

                const data = await response.json();
                const vehicle = data.vehicle;
                const owner = data.owner;

                // Set vehicle details
                document.getElementById('edit_vehicle_id').value = vehicle.reg_vehicle_id;
                document.getElementById('edit_plate_number').value = vehicle.plate_number;
                document.getElementById('edit_vehicle_type').value = vehicle.vehicle_type;
                document.getElementById('edit_brand').value = vehicle.brand;
                document.getElementById('edit_color').value = vehicle.color;
                document.getElementById('edit_registration_date').value = vehicle.registration_date;

                // Populate models based on brand and set selected model
                populateModels(vehicle.brand);
                document.getElementById('edit_model').value = vehicle.model;

                // Set owner details
                document.getElementById('edit_owner_id').value = owner.own_id;
                document.getElementById('edit_owner_name').value = `${owner.user.lname}, ${owner.user.fname} ${owner.user.mname || ''}`;
                document.getElementById('edit_address').value = owner.address;
                document.getElementById('edit_contact_num').value = owner.contact_num;
                document.getElementById('edit_license_number').value = owner.license_number;

                // Show the modal
                document.getElementById('editVehicleModal').style.display = 'block';
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to load vehicle details. Please try again.');
            }
        }

        function closeEditVehicleModal() {
            document.getElementById('editVehicleModal').style.display = 'none';
        }

        function openDeleteVehicleModal(vehicleId) {
            document.getElementById('delete_vehicle_id').value = vehicleId;
            document.getElementById('deleteVehicleModal').style.display = 'block';
        }

        function closeDeleteVehicleModal() {
            document.getElementById('deleteVehicleModal').style.display = 'none';
        }

        function populateModels(brand, selectedModel = null) {
            const modelSelect = document.getElementById('edit_model');
            modelSelect.innerHTML = '<option value="" disabled>Select Model</option>';

            const models = {
                'Toyota': ['Camry', 'Corolla', 'RAV4', 'Hilux', 'Land Cruiser', 'Fortuner', 'Vios', 'Innova', 'Avanza'],
                'Honda': ['Civic', 'CR-V', 'City', 'Accord', 'HR-V', 'BR-V', 'Jazz', 'Pilot', 'Click', 'PCX'],
                'Ford': ['Ranger', 'Everest', 'EcoSport', 'Explorer', 'Mustang', 'Territory', 'F-150', 'Bronco'],
                'BMW': ['3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5', 'X7', 'M3', 'M5'],
                'Mercedes-Benz': ['C-Class', 'E-Class', 'S-Class', 'GLA', 'GLC', 'GLE', 'G-Class', 'A-Class'],
                'Hyundai': ['Tucson', 'Santa Fe', 'Accent', 'Elantra', 'Kona', 'Creta', 'Starex', 'Palisade'],
                'Tesla': ['Model 3', 'Model S', 'Model X', 'Model Y', 'Cybertruck'],
                'Yamaha': ['Mio', 'NMAX', 'Aerox', 'MT-07', 'MT-09', 'YZF-R1', 'YZF-R6', 'XSR155', 'Sniper'],
                'Suzuki': ['Raider', 'Smash', 'Burgman', 'Gixxer', 'GSX-R750', 'Hayabusa', 'V-Strom', 'Access']
            };

            if (models[brand]) {
                models[brand].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    if (model === selectedModel) option.selected = true;
                    modelSelect.appendChild(option);
                });
            }
        }

        // Update model list when brand changes
        document.getElementById('edit_brand').addEventListener('change', function() {
            populateModels(this.value);
        });

        window.onclick = function(event) {
            const registerVehicleModal = document.getElementById('registerVehicleModal');
            const editVehicleModal = document.getElementById('editVehicleModal');
            const deleteVehicleModal = document.getElementById('deleteVehicleModal');
            
            if (event.target === registerVehicleModal) {
                closeVehicleModal();
            } else if (event.target === editVehicleModal) {
                closeEditVehicleModal();
            } else if (event.target === deleteVehicleModal) {
                closeDeleteVehicleModal();
            }
        }

        const vehicleModels = {
            'Toyota': ['Camry', 'Corolla', 'RAV4', 'Hilux', 'Land Cruiser', 'Fortuner', 'Vios', 'Innova', 'Avanza'],
            'Honda': ['Civic', 'CR-V', 'City', 'Accord', 'HR-V', 'BR-V', 'Jazz', 'Pilot', 'Click', 'PCX'],
            'Ford': ['Ranger', 'Everest', 'EcoSport', 'Explorer', 'Mustang', 'Territory', 'F-150', 'Bronco'],
            'BMW': ['3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5', 'X7', 'M3', 'M5'],
            'Mercedes-Benz': ['C-Class', 'E-Class', 'S-Class', 'GLA', 'GLC', 'GLE', 'G-Class', 'A-Class'],
            'Hyundai': ['Tucson', 'Santa Fe', 'Accent', 'Elantra', 'Kona', 'Creta', 'Starex', 'Palisade'],
            'Tesla': ['Model 3', 'Model S', 'Model X', 'Model Y', 'Cybertruck'],
            'Yamaha': ['Mio', 'NMAX', 'Aerox', 'MT-07', 'MT-09', 'YZF-R1', 'YZF-R6', 'XSR155', 'Sniper'],
            'Suzuki': ['Raider', 'Smash', 'Burgman', 'Gixxer', 'GSX-R750', 'Hayabusa', 'V-Strom', 'Access']
        };

        // Function to update model options based on selected brand
        function updateModels(brandSelect, modelSelect) {
            const brand = brandSelect.value;
            const models = vehicleModels[brand] || [];
            
            // Clear existing options
            modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';
            
            // Add new options
            models.forEach(model => {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                modelSelect.appendChild(option);
            });
        }

        // Add event listeners when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // For the register form
            const brandSelect = document.getElementById('brand');
            const modelSelect = document.getElementById('model');
            if (brandSelect && modelSelect) {
                brandSelect.addEventListener('change', () => updateModels(brandSelect, modelSelect));
            }

            // For the edit form
            const editBrandSelect = document.getElementById('edit_brand');
            const editModelSelect = document.getElementById('edit_model');
            if (editBrandSelect && editModelSelect) {
                editBrandSelect.addEventListener('change', () => updateModels(editBrandSelect, editModelSelect));
            }
        });

        // Add the approve/reject functions
        function approveRequest(requestId) {
            if (confirm('Are you sure you want to approve this request?')) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                fetch(`/dashboard/admin/vehicle-registration-requests/${requestId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message || 'Request approved successfully!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to approve request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while approving the request. Please try again.');
                });
            }
        }

        function rejectRequest(requestId) {
            if (confirm('Are you sure you want to reject this request?')) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/dashboard/admin/vehicle-registration-requests/${requestId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message || 'Request rejected successfully!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to reject request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while rejecting the request. Please try again.');
                });
            }
        }

        function toggleRequestsSection() {
            const section = document.getElementById('requestsSection');
            const icon = document.getElementById('toggleIcon');
            
            if (section.style.display === 'none') {
                section.style.display = 'block';
                icon.className = 'fas fa-minus';
                localStorage.setItem('requestsSectionState', 'expanded');
            } else {
                section.style.display = 'none';
                icon.className = 'fas fa-plus';
                localStorage.setItem('requestsSectionState', 'collapsed');
            }
        }

        // Restore the section state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const section = document.getElementById('requestsSection');
            const icon = document.getElementById('toggleIcon');
            const savedState = localStorage.getItem('requestsSectionState');
            
            if (savedState === 'collapsed') {
                section.style.display = 'none';
                icon.className = 'fas fa-plus';
            }
        });
    </script>
</body>
</html>