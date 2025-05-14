<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Violation History - Guest Dashboard</title>
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
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-paid {
            background-color: #10b981;
            color: white;
        }

        .status-unpaid {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ route('dashboard.guest') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('violation.history') }}" class="active"><i class="fas fa-history"></i> Violation History</a>
                <a href="{{ route('blacklist.status') }}"><i class="fas fa-user-slash"></i> Blacklist Status</a>
                <a href="{{ route('pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
                <a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>My Violation History</h1>
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
                            <td>₱{{ number_format($record->PenaltyAmount, 2) }}</td>
                            <td>{{ $record->PlateNumber }}</td>
                            <td>{{ $record->OfficerLastName }}</td>
                            <td>{{ $record->OfficerFirstName }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->ViolationDate)->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($record->Status) }}">
                                    {{ ucfirst($record->Status) }}
                                </span>
                            </td>
                            <td>
                                @if($record->isReport)
                                    <button class="btn btn-info" onclick="viewReportDetails('{{ addslashes($record->Description) }}', '{{ $record->RecordID }}', '{{ $record->ViolationDate }}', '{{ $record->OfficerFirstName }} {{ $record->OfficerLastName }}')">
                                        View Details
                                    </button>
                                @elseif($record->hasReport)
                                    <button class="btn btn-info" onclick="viewReportDetails('{{ addslashes($record->reportDetails) }}', '{{ $record->RecordID }}', '{{ $record->ViolationDate }}', '{{ $record->OfficerFirstName }} {{ $record->OfficerLastName }}')">
                                        View Report
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Modal for Report Details -->
            <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel">Report Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="report-info">
                                <p><strong>Record ID:</strong> <span id="recordId"></span></p>
                                <p><strong>Date:</strong> <span id="reportDate"></span></p>
                                <p><strong>Officer:</strong> <span id="officerName"></span></p>
                            </div>
                            <hr>
                            <div class="report-content">
                                <h6>Report Details:</h6>
                                <p id="detailsContent"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function viewReportDetails(details, recordId, date, officerName) {
                    document.getElementById('detailsContent').textContent = details;
                    document.getElementById('recordId').textContent = recordId;
                    document.getElementById('reportDate').textContent = date;
                    document.getElementById('officerName').textContent = officerName;
                    $('#detailsModal').modal('show');
                }
            </script>
        </div>
    </div>
</body>
</html>