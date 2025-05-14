<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Violation Records - Admin Dashboard</title>
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
            <h1>Violation Records</h1>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by Officer Name or Plate Number" onkeyup="filterRecords()">
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
                        <th>Plate Number</th>
                        <th>Officer Last Name</th>
                        <th>Officer First Name</th>
                        <th>Violation Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($allRecords->isEmpty())
                        <tr>
                            <td colspan="10" class="no-records">No records found.</td>
                        </tr>
                    @else
                        @foreach($allRecords as $record)
                        <tr>
                            <td>{{ $record->RecordID }}</td>
                            <td>{{ $record->violationCode }}</td>
                            <td>{{ $record->Description }}</td>
                            <td>{{ $record->PenaltyAmount }}</td>
                            <td>{{ $record->PlateNumber }}</td>
                            <td>{{ $record->OfficerLastName }}</td>
                            <td>{{ $record->OfficerFirstName }}</td>
                            <td>{{ $record->ViolationDate }}</td>
                            <td>{{ $record->Status }}</td>
                            <td>
                                @if(isset($record->isReport))
                                    <button class="btn btn-info" onclick="viewReportDetails('{{ $record->Description }}')">
                                        View Details
                                    </button>
                                @else
                                    <button class="btn" onclick="updateStatus({{ $record->RecordID }})">Update Status</button>
                                    <button class="btn" onclick="attachDocument({{ $record->RecordID }})">Attach Document</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Modal for Report Details -->
            <div class="modal fade" id="reportDetailsModal" tabindex="-1" role="dialog" aria-labelledby="reportDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportDetailsModalLabel">Report Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="reportDetailsContent"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function viewReportDetails(details) {
                    document.getElementById('reportDetailsContent').textContent = details;
                    $('#reportDetailsModal').modal('show');
                }

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