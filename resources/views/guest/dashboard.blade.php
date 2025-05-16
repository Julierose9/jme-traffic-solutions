<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guest Dashboard - JME Traffic Violation System</title>
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

        .stats-card {
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 1rem;
        }

        .stats-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
        }

        .stats-card p {
            font-size: 1rem;
            color: #0a1f44;
        }

        .welcome-message {
            margin-bottom: 2rem;
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

        .color-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .stat-item {
            background: #fff;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #0a1f44;
            margin: 10px 0;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: 500;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Personal Information Card Styles */
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            border: none;
        }
        .card-body {
            padding: 2rem;
        }
        .card-title {
            color: #0a1f44;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #edf2f7;
            text-align: center;
        }
        .table-borderless {
            margin-bottom: 0;
        }
        .table-borderless th {
            font-weight: 600;
            color: #4a5568;
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }
        .table-borderless td {
            color: #2d3748;
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }
        .table-borderless tr {
            line-height: 2.5;
        }
        .stats-card.mb-4 {
            background-color: transparent;
            box-shadow: none;
            padding: 0;
        }
        .stats-card.mb-4 h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #1a202c;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .mb-3 {
            margin-bottom: 1rem;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow-y: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            position: relative;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .btn-primary {
            background-color: #0a1f44;
            border: none;
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #152a4e;
            transform: translateY(-1px);
        }

        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #0a1f44;
            box-shadow: 0 0 0 0.2rem rgba(10, 31, 68, 0.25);
            outline: none;
        }

        .w-100 {
            width: 100%;
        }

        .stat-number a {
            text-decoration: none;
        }
        .stat-number a:hover {
            text-decoration: underline;
        }
        .btn-block {
            margin-bottom: 10px;
        }
        .table-responsive {
            margin-top: 15px;
        }
        .alert {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
            <a href="{{ route('dashboard.guest') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('violation.history') }}"><i class="fas fa-exclamation-triangle"></i>Violation History</a>
                <a href="{{ route('blacklist.status') }}"><i class="fas fa-user-slash"></i> Blacklist Status</a>
                <a href="{{ route('pay.fines') }}" class="hover:bg-blue-800"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
                <a href="{{ route('support') }}" class="hover:bg-blue-800"><i class="fas fa-headset"></i> Support</a> 
              </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="main-content">
            <h1 class="text-2xl font-bold">Guest Dashboard</h1>
            <p class="text-gray-600 welcome-message">Welcome! Today is <strong>{{ date('l, F j, Y') }}</strong>.</p>
            
            <div class="stats-card mb-4">
                <h2 class="mb-3">Personal Information</h2>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title mb-3 text-center">Owner Details</h3>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Name:</th>
                                        <td>{{ Auth::user()->lname }}, {{ Auth::user()->fname }} {{ Auth::user()->mname }}</td>
                                    </tr>
                                    @if(Auth::user()->owner)
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ Auth::user()->owner->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Number:</th>
                                        <td>{{ Auth::user()->owner->contact_num }}</td>
                                    </tr>
                                    <tr>
                                        <th>License Number:</th>
                                        <td>{{ Auth::user()->owner->license_number }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <h2>Your Registered Vehicles</h2>
                @if(isset($registeredVehicles) && $registeredVehicles->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div></div>
                        <button class="btn btn-primary" onclick="openRequestVehicleModal()">
                            <i class="fas fa-plus"></i> Request Vehicle Registration
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Plate Number</th>
                                    <th>Vehicle Type</th>
                                    <th>Brand & Model</th>
                                    <th>Color</th>
                                    <th>Registration Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registeredVehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->plate_number }}</td>
                                        <td>{{ $vehicle->vehicle_type }}</td>
                                        <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                        <td>
                                            <span class="color-dot" style="background-color: {{ strtolower($vehicle->color) }}"></span>
                                            {{ $vehicle->color }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($vehicle->registration_date)->format('M d, Y') }}</td>
                                        <td>
                                            @if($vehicle->blacklists->count() > 0)
                                                <span class="badge badge-danger">Blacklisted</span>
                                            @elseif($vehicle->violationRecords->where('status', 'unpaid')->count() > 0)
                                                <span class="badge badge-warning">Has Unpaid Violations</span>
                                            @else
                                                <span class="badge badge-success">Clear</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-600">No vehicles registered yet.</p>
                @endif
            </div>

            <div class="stats-card">
                <h2><i class="fas fa-chart-bar"></i> Vehicle Statistics</h2>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h4>Total Vehicles</h4>
                            <p class="stat-number">{{ $registeredVehicles->count() }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h4>Active Violations</h4>
                            <p class="stat-number">
                                <a href="{{ route('pay.fines') }}" class="text-danger">
                                    {{ $pendingPayments }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h4>Blacklisted</h4>
                            <p class="stat-number">{{ $registeredVehicles->sum(function($vehicle) {
                                return $vehicle->blacklists()->where('status', 'Active')->count();
                            }) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Violations Section -->
            <!-- <div class="stats-card mt-4">
                <h2><i class="fas fa-exclamation-triangle"></i> Active Violations</h2>
                @php
                    $activeViolations = collect();
                    foreach($registeredVehicles as $vehicle) {
                        $violations = $vehicle->violationRecords()->where('status', 'unpaid')->get();
                        foreach($violations as $violation) {
                            $activeViolations->push([
                                'vehicle' => $vehicle,
                                'violation' => $violation
                            ]);
                        }
                    }
                @endphp

                @if($activeViolations->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Violation</th>
                                    <th>Penalty Amount</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeViolations as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record['violation']->violation_date)->format('M d, Y') }}</td>
                                        <td>{{ $record['vehicle']->plate_number }} ({{ $record['vehicle']->brand }} {{ $record['vehicle']->model }})</td>
                                        <td>{{ $record['violation']->violation_code }}</td>
                                        <td>₱{{ number_format($record['violation']->penalty_amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-danger">Violation</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pay.fines') }}" class="btn btn-danger btn-sm">
                                                <i class="fas fa-money-bill-wave"></i> Pay Fine
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle"></i> You have no active violations.
                    </div>
                @endif
            </div> -->

            <div class="stats-card">
                <h2>Quick Links</h2>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('violation.history') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-history"></i> View Violation History
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pay.fines') }}" class="btn btn-danger btn-block">
                            <i class="fas fa-money-bill-wave"></i> Pay Outstanding Fines
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('blacklist.status') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-user-slash"></i> Check Blacklist Status
                        </a>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <h2><i class="fas fa-headset"></i> Need Assistance?</h2>
                <p>If you have any questions or need help, our support team is here to assist you.</p>
                <a href="{{ route('support') }}" class="btn btn-info">
                    <i class="fas fa-envelope"></i> Contact Support
                </a>
            </div>
        </div>
    </div>

    <!-- Request Vehicle Registration Modal -->
    <div id="requestVehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRequestVehicleModal()">&times;</span>
            <h2>Request Vehicle Registration</h2>
            <form id="requestVehicleForm" method="POST" action="{{ route('request.vehicle.registration') }}">
                @csrf
                <div class="form-group">
                    <label for="request_vehicle_type">Vehicle Type:</label>
                    <select id="request_vehicle_type" name="vehicle_type" required class="form-control">
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
                    <label for="request_brand">Brand:</label>
                    <select id="request_brand" name="brand" required class="form-control">
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
                    <label for="request_model">Model:</label>
                    <select id="request_model" name="model" required class="form-control">
                        <option value="" disabled selected>Select Model</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="request_plate_number">Plate Number:</label>
                    <input type="text" id="request_plate_number" name="plate_number" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="request_color">Color:</label>
                    <select id="request_color" name="color" required class="form-control">
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
                    <label for="request_notes">Additional Notes:</label>
                    <textarea id="request_notes" name="notes" class="form-control" rows="3" placeholder="Any additional information about the vehicle..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Vehicle models data
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

        document.addEventListener('DOMContentLoaded', function() {
            // For the request vehicle form
            const requestBrandSelect = document.getElementById('request_brand');
            const requestModelSelect = document.getElementById('request_model');
            if (requestBrandSelect && requestModelSelect) {
                requestBrandSelect.addEventListener('change', () => updateModels(requestBrandSelect, requestModelSelect));
            }

            // Handle request form submission
            const requestForm = document.getElementById('requestVehicleForm');
            if (requestForm) {
                requestForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('Form submission started'); // Debug log
                    
                    // Get form data
                    const formData = new FormData(this);
                    
                    // Log form data for debugging
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }

                    // Get CSRF token
                    const token = document.querySelector('meta[name="csrf-token"]').content;
                    console.log('CSRF Token:', token); // Debug log
                    
                    // Submit the form
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        console.log('Response status:', response.status); // Debug log
                        if (!response.ok) {
                            return response.json().then(data => Promise.reject(data));
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data); // Debug log
                        if (data.success) {
                            alert('Vehicle registration request submitted successfully!');
                            closeRequestVehicleModal();
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to submit request');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (error.errors) {
                            // Handle validation errors
                            const errorMessages = Object.values(error.errors).flat().join('\n');
                            alert('Validation failed:\n' + errorMessages);
                        } else {
                            alert('An error occurred while submitting the request. Please try again.');
                        }
                    });
                });
            } else {
                console.error('Request form not found!'); // Debug log
            }
        });

        function openRequestVehicleModal() {
            document.getElementById('requestVehicleModal').style.display = 'block';
        }

        function closeRequestVehicleModal() {
            document.getElementById('requestVehicleModal').style.display = 'none';
            // Reset form
            document.getElementById('requestVehicleForm').reset();
            // Reset model dropdown
            const modelSelect = document.getElementById('request_model');
            modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const requestVehicleModal = document.getElementById('requestVehicleModal');
            if (event.target === requestVehicleModal) {
                closeRequestVehicleModal();
            }
        }
    </script>
</body>
</html>