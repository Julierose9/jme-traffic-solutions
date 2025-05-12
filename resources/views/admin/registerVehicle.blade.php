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

        form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            <h1>Registered Vehicles</h1>
            <button class="btn" onclick="openOwnerModal()">Register a Vehicle</button>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="registerOwnerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRegisterOwnerModal()">×</span>
            <h2>Register New Owner</h2>
            <form id="registerOwnerForm" method="POST" action="{{ route('register.owner.submit') }}" onsubmit="event.preventDefault(); handleOwnerSubmit(event);">
                @csrf
                <div>
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" required>
                </div>
                <div>
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div>
                    <label for="mname">Middle Name:</label>
                    <input type="text" id="mname" name="mname">
                </div>
                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div>
                    <label for="contact_num">Contact Number:</label>
                    <input type="text" id="contact_num" name="contact_num" required>
                </div>
                <div>
                    <label for="license_number">License Number:</label>
                    <input type="text" id="license_number" name="license_number" required>
                </div>
                <button type="submit">Register Owner</button>
            </form>
        </div>
    </div>

    <div id="registerVehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeVehicleModal()">×</span>
            <h2>Register a Vehicle</h2>
            <form id="registerVehicleForm" method="POST" action="{{ route('register.vehicle.submit') }}">
                @csrf
                <input type="hidden" id="selected_owner_id" name="own_id">
                <div>
                    <label for="plate_number">Plate Number:</label>
                    <input type="text" id="plate_number" name="plate_number" required>
                </div>
                <div>
                    <label for="vehicle_type">Vehicle Type:</label>
                    <input type="text" id="vehicle_type" name="vehicle_type" required>
                </div>
                <div>
                    <label for="brand">Brand:</label>
                    <input type="text" id="brand" name="brand" required>
                </div>
                <div>
                    <label for="model">Model:</label>
                    <input type="text" id="model" name="model" required>
                </div>
                <div>
                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" required>
                </div>
                <div>
                    <label for="registration_date">Registration Date:</label>
                    <input type="date" id="registration_date" name="registration_date" required>
                </div>
                <button type="submit">Register Vehicle</button>
            </form>
        </div>
    </div>

    <script>
        function openOwnerModal() {
            document.getElementById('registerOwnerModal').style.display = 'block';
        }

        function closeRegisterOwnerModal() {
            document.getElementById('registerOwnerModal').style.display = 'none';
        }

        function openVehicleModal() {
            document.getElementById('registerVehicleModal').style.display = 'block';
        }

        function closeVehicleModal() {
            document.getElementById('registerVehicleModal').style.display = 'none';
        }

        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        function handleOwnerSubmit(event) {
            event.preventDefault();
            console.log('Form submission triggered');
            const form = event.target;
            const formData = new FormData(form);
            console.log('Form data:', Object.fromEntries(formData));
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response received:', response);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.success) {
                    document.getElementById('selected_owner_id').value = data.owner_id;
                    closeRegisterOwnerModal();
                    openVehicleModal();
                } else {
                    alert(data.message || 'Failed to register owner');
                }
            })
            .catch(error => {
                console.error('Error during fetch:', error);
                alert('An error occurred while registering the owner. Check the console for details.');
            });
        }

        window.onclick = function(event) {
            const registerOwnerModal = document.getElementById('registerOwnerModal');
            const vehicleModal = document.getElementById('registerVehicleModal');
            if (event.target === registerOwnerModal) {
                closeRegisterOwnerModal();
            } else if (event.target === vehicleModal) {
                closeVehicleModal();
            }
        }
    </script>
</body>
</html>