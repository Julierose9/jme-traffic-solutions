<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Issue Violation - Admin Dashboard</title>
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
        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .search-container input {
            width: 45%;
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
        .modal-header {
            background-color: #0a1f44;
            color: white;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('/issue-violation') }}" class="active" id="sidebarOpenModalBtn" data-toggle="modal" data-target="#generateViolationModal"><i class="fas fa-exclamation-triangle"></i> Issue Violation</a>
                <a href="{{ route('reports.index') }}"><i class="fas fa-folder-open"></i> Reports</a>            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>Issue Violation</h1>
            <button class="btn" data-toggle="modal" data-target="#generateViolationModal">Generate Violation</button>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by Officer Name" onkeyup="filterRecords()">
                <button class="search-button" onclick="filterRecords()">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <table class="table" id="recordsTable">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Violation Code</th>
                        <th>Description</th>
                        <th>Penalty Amount</th>
                        <th>Officer Last Name</th>
                        <th>Officer First Name</th>
                        <th>Violation Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($violationRecords->isEmpty())
                        <tr>
                            <td colspan="9" class="no-records">No violation records found.</td>
                        </tr>
                    @else
                        @foreach($violationRecords as $record)
                        <tr>
                            <td>{{ $record->RecordID }}</td>
                            <td>{{ $record->violationCode }}</td>
                            <td>{{ $record->Description }}</td>
                            <td>{{ $record->PenaltyAmount }}</td>
                            <td>{{ $record->OfficerLastName }}</td>
                            <td>{{ $record->OfficerFirstName }}</td>
                            <td>{{ $record->ViolationDate }}</td>
                            <td>{{ $record->Status }}</td>
                            <td>
                                <button class="btn" onclick="updateStatus({{ $record->RecordID                                }})">Update Status</button>
                                <button class="btn" onclick="attachDocument({{ $record->RecordID }})">Attach Document</button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="generateViolationModal" tabindex="-1" role="dialog" aria-labelledby="generateViolationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateViolationModalLabel">Generate Violation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('violation.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="violation_code">Violation Code</label>
                            <input type="text" class="form-control" id="violation_code" name="violation_code" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="penalty_amount">Penalty Amount</label>
                            <input type="number" class="form-control" id="penalty_amount" name="penalty_amount" required>
                        </div>
                        <div class="form-group">
                            <label for="plate_number">Plate Number</label>
                            <input type="text" class="form-control" id="plate_number" name="plate_number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Violation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function filterRecords() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('recordsTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdOfficerLastName = tr[i].getElementsByTagName('td')[5];
                const tdPlateNumber = tr[i].getElementsByTagName('td')[4];
                if (tdOfficerLastName || tdPlateNumber) {
                    const txtOfficerLastName = tdOfficerLastName.textContent || tdOfficerLastName.innerText;
                    const txtPlateNumber = tdPlateNumber.textContent || tdPlateNumber.innerText;
                    if (txtOfficerLastName.toLowerCase().indexOf(filter) > -1 || txtPlateNumber.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

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

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>