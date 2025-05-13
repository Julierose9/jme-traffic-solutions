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
        #generateViolationModal {
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
            width: 30%;
            border-radius: 5px;
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
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('/issue-violation') }}" class="active" id="sidebarOpenModalBtn"><i class="fas fa-exclamation-triangle"></i> Issue Violation</a>
                <a href="{{ route('reports.index') }}"><i class="fas fa-folder-open"></i> Reports</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>Issue Violation</h1>
            <button class="btn" onclick="openGenerateViolationModal()">Generate Violation</button>
            <table class="table" id="violationTable">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($violationRecords as $record)
                        <tr>
                            <td>{{ $record->record_id }}</td>
                            <td>{{ $record->violation_code }}</td>
                            <td>{{ $record->description }}</td>
                            <td>{{ $record->penalty_amount }}</td>
                            <td>{{ $record->officer_last_name }}</td>
                            <td>{{ $record->officer_first_name }}</td>
                            <td>{{ $record->violation_date }}</td>
                            <td>{{ $record->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="generateViolationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeGenerateViolationModal()">×</span>
            <h2>Generate Violation</h2>
            <form id="violationForm" action="/dashboard/officer/violation" method="POST">
                @csrf
                <input type="hidden" id="record_id" name="record_id">
                <div class="form-group">
                    <label for="violation_code">Violation Code:</label>
                    <input type="text" class="form-control" id="violation_code" name="violation_code" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="penalty_amount">Penalty Amount:</label>
                    <input type="number" class="form-control" id="penalty_amount" name="penalty_amount" required>
                </div>
                <div class="form-group">
                    <label for="officer_last_name">Officer Last Name:</label>
                    <input type="text" class="form-control" id="officer_last_name" name="officer_last_name" required>
                </div>
                <div class="form-group">
                    <label for="officer_first_name">Officer First Name:</label>
                    <input type="text" class="form-control" id="officer_first_name" name="officer_first_name" required>
                </div>
                <div class="form-group">
                    <label for="violation_date">Violation Date:</label>
                    <input type="date" class="form-control" id="violation_date" name="violation_date" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Resolved">Resolved</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn">Generate Violation</button>
            </form>
        </div>
    </div>

    <script>
        let recordIdCounter = 0;

        function openGenerateViolationModal() {
            document.getElementById('generateViolationModal').style.display = 'block';
            recordIdCounter++;
            const recordId = 'REC' + recordIdCounter.toString().padStart(4, '0');
            document.getElementById('record_id').value = recordId;
        }

        function closeGenerateViolationModal() {
            document.getElementById('generateViolationModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const violationModal = document.getElementById('generateViolationModal');
            if (event.target === violationModal) {
                closeGenerateViolationModal();
            }
        }

        function handleViolationSubmit(event) {
            event.preventDefault(); // Prevent form submission from reloading the page
            const form = document.getElementById('violationForm');
            const formData = new FormData(form);
            const table = document.getElementById('violationTable').getElementsByTagName('tbody')[0];

            fetch(form.action, {
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
                    // Use the data returned from the server to populate the table
                    const violation = data.violation;
                    const newRow = table.insertRow();
                    newRow.innerHTML = `
                        <td>${violation.record_id}</td>
                        <td>${violation.violation_code}</td>
                        <td>${violation.description}</td>
                        <td>${violation.penalty_amount}</td>
                        <td>${violation.officer_last_name}</td>
                        <td>${violation.officer_first_name}</td>
                        <td>${violation.violation_date}</td>
                        <td>${violation.status}</td>
                    `;

                    // Reset form and close modal
                    form.reset();
                    closeGenerateViolationModal();
                } else {
                    alert(data.message || 'Failed to generate violation');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while generating the violation.');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('violationForm').addEventListener('submit', handleViolationSubmit);
        });
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>