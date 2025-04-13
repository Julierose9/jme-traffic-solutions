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
                <a href="{{ route('pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
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
                            <button class="edit-btn" onclick="openEditVehicleModal('{{ $vehicle->reg_vehicle_id }}', '{{ $vehicle->own_id }}', '{{ $vehicle->plate_number }}', '{{ $vehicle->vehicle_type }}', '{{ $vehicle->brand }}', '{{ $vehicle->model }}', '{{ $vehicle->color }}', '{{ $vehicle->registration_date }}')"><i class="fas fa-edit"></i> Edit</button>
                            <button class="delete-btn" onclick="openDeleteVehicleModal('{{ $vehicle->reg_vehicle_id }}')"><i class="fas fa-trash"></i> Delete</button>
                        </td>
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
                    <select id="vehicle_type" name="vehicle_type" required>
                        <option value="" disabled selected>Select Vehicle Type</option>
                        <option value="Car">Car</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Truck">Truck</option>
                        <option value="Van">Van</option>
                        <option value="SUV">SUV</option>
                        <option value="Bus">Bus</option>
                    </select>
                </div>
                <div>
                    <label for="brand">Brand:</label>
                    <select id="brand" name="brand" required>
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
                <div>
                    <label for="model">Model:</label>
                    <select id="model" name="model" required>
                        <option value="" disabled selected>Select Model</option>
                    </select>
                </div>
                <div>
                    <label for="color">Color:</label>
                    <select id="color" name="color" required>
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
                <div>
                    <label for="registration_date">Registration Date:</label>
                    <input type="date" id="registration_date" name="registration_date" required>
                </div>
                <button type="submit">Register Vehicle</button>
            </form>
        </div>
    </div>

    <div id="editVehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditVehicleModal()">×</span>
            <h2>Edit Vehicle</h2>
            <form id="editVehicleForm" method="POST" action="{{ route('edit.vehicle.submit') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_vehicle_id" name="reg_vehicle_id">
                <input type="hidden" id="edit_owner_id" name="own_id">
                <div>
                    <label for="edit_plate_number">Plate Number:</label>
                    <input type="text" id="edit_plate_number" name="plate_number" required>
                </div>
                <div>
                    <label for="edit_vehicle_type">Vehicle Type:</label>
                    <select id="edit_vehicle_type" name="vehicle_type" required>
                        <option value="" disabled>Select Vehicle Type</option>
                        <option value="Car">Car</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Truck">Truck</option>
                        <option value="Van">Van</option>
                        <option value="SUV">SUV</option>
                        <option value="Bus">Bus</option>
                    </select>
                </div>
                <div>
                    <label for="edit_brand">Brand:</label>
                    <select id="edit_brand" name="brand" required>
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
                <div>
                    <label for="edit_model">Model:</label>
                    <select id="edit_model" name="model" required>
                        <option value="" disabled>Select Model</option>
                    </select>
                </div>
                <div>
                    <label for="edit_color">Color:</label>
                    <select id="edit_color" name="color" required>
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
                <div>
                    <label for="edit_registration_date">Registration Date:</label>
                    <input type="date" id="edit_registration_date" name="registration_date" required>
                </div>
                <button type="submit">Update Vehicle</button>
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
                    <button type="submit" style="background-color: #dc2626;">Delete</button>
                    <button type="button" onclick="closeDeleteVehicleModal()" style="background-color: #6b7280;">Cancel</button>
                </div>
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

        function openEditVehicleModal(vehicleId, ownerId, plateNumber, vehicleType, brand, model, color, registrationDate) {
            document.getElementById('edit_vehicle_id').value = vehicleId;
            document.getElementById('edit_owner_id').value = ownerId;
            document.getElementById('edit_plate_number').value = plateNumber;
            document.getElementById('edit_vehicle_type').value = vehicleType;
            document.getElementById('edit_brand').value = brand;
            document.getElementById('edit_color').value = color;
            document.getElementById('edit_registration_date').value = registrationDate;

            // Populate models based on brand
            const modelSelect = document.getElementById('edit_model');
            modelSelect.innerHTML = '<option value="" disabled>Select Model</option>';
            const models = {
                'Toyota': ['Camry', 'Corolla', 'RAV4', 'Prius'],
                'Honda': ['Civic', 'Accord', 'CR-V', 'Fit'],
                'Ford': ['F-150', 'Mustang', 'Explorer', 'Focus'],
                'BMW': ['X5', '3 Series', '5 Series', 'M3'],
                'Mercedes-Benz': ['C-Class', 'E-Class', 'S-Class', 'GLC'],
                'Hyundai': ['Tucson', 'Elantra', 'Santa Fe', 'Sonata'],
                'Tesla': ['Model 3', 'Model S', 'Model X', 'Model Y'],
                'Yamaha': ['YZF-R1', 'MT-07', 'FJR1300', 'V Star'],
                'Suzuki': ['Swift', 'Vitara', 'Jimny', 'GSX-R1000']
            };

            if (models[brand]) {
                models[brand].forEach(m => {
                    const option = document.createElement('option');
                    option.value = m;
                    option.textContent = m;
                    if (m === model) option.selected = true;
                    modelSelect.appendChild(option);
                });
            }

            document.getElementById('editVehicleModal').style.display = 'block';
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

        // Dynamic model population for register vehicle modal
        document.getElementById('brand').addEventListener('change', function() {
            const brand = this.value;
            const modelSelect = document.getElementById('model');
            modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';

            const models = {
                'Toyota': ['Camry', 'Corolla', 'RAV4', 'Prius'],
                'Honda': ['Civic', 'Accord', 'CR-V', 'Fit'],
                'Ford': ['F-150', 'Mustang', 'Explorer', 'Focus'],
                'BMW': ['X5', '3 Series', '5 Series', 'M3'],
                'Mercedes-Benz': ['C-Class', 'E-Class', 'S-Class', 'GLC'],
                'Hyundai': ['Tucson', 'Elantra', 'Santa Fe', 'Sonata'],
                'Tesla': ['Model 3', 'Model S', 'Model X', 'Model Y'],
                'Yamaha': ['YZF-R1', 'MT-07', 'FJR1300', 'V Star'],
                'Suzuki': ['Swift', 'Vitara', 'Jimny', 'GSX-R1000']
            };

            if (models[brand]) {
                models[brand].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            }
        });

        // Dynamic model population for edit vehicle modal
        document.getElementById('edit_brand').addEventListener('change', function() {
            const brand = this.value;
            const modelSelect = document.getElementById('edit_model');
            modelSelect.innerHTML = '<option value="" disabled>Select Model</option>';

            const models = {
                'Toyota': ['Camry', 'Corolla', 'RAV4', 'Prius'],
                'Honda': ['Civic', 'Accord', 'CR-V', 'Fit'],
                'Ford': ['F-150', 'Mustang', 'Explorer', 'Focus'],
                'BMW': ['X5', '3 Series', '5 Series', 'M3'],
                'Mercedes-Benz': ['C-Class', 'E-Class', 'S-Class', 'GLC'],
                'Hyundai': ['Tucson', 'Elantra', 'Santa Fe', 'Sonata'],
                'Tesla': ['Model 3', 'Model S', 'Model X', 'Model Y'],
                'Yamaha': ['YZF-R1', 'MT-07', 'FJR1300', 'V Star'],
                'Suzuki': ['Swift', 'Vitara', 'Jimny', 'GSX-R1000']
            };

            if (models[brand]) {
                models[brand].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            }
        });

        window.onclick = function(event) {
            const registerOwnerModal = document.getElementById('registerOwnerModal');
            const vehicleModal = document.getElementById('registerVehicleModal');
            const editVehicleModal = document.getElementById('editVehicleModal');
            const deleteVehicleModal = document.getElementById('deleteVehicleModal');
            if (event.target === registerOwnerModal) {
                closeRegisterOwnerModal();
            } else if (event.target === vehicleModal) {
                closeVehicleModal();
            } else if (event.target === editVehicleModal) {
                closeEditVehicleModal();
            } else if (event.target === deleteVehicleModal) {
                closeDeleteVehicleModal();
            }
        }
    </script>
</body>
</html>