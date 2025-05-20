<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blacklist Status - Guest</title>
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

        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #0a1f44;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            display: inline-block;
        }

        .status-active {
            background-color: #ef4444;
            color: white;
        }

        .status-pending {
            background-color: #f59e0b;
            color: white;
        }

        .status-resolved {
            background-color: #10b981;
            color: white;
        }

        .report-details {
            background-color: #f8fafc;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .report-details h5 {
            color: #0a1f44;
            margin-bottom: 0.5rem;
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

        .no-records {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .no-records i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #9ca3af;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
            max-height: 80vh;
            overflow-y: auto;
        }
        .modal .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }
        .modal .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ route('dashboard.guest') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('violation.history') }}"><i class="fas fa-exclamation-triangle"></i> Violation History</a>
                <a href="{{ route('blacklist.status') }}" class="active"><i class="fas fa-user-slash"></i> Blacklist Status</a>
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
            <h1 class="text-2xl font-bold mb-4">My Blacklist Status</h1>

            @if($blacklistStatus->isEmpty())
                <div class="no-records">
                    <i class="fas fa-check-circle"></i>
                    <h2 class="text-xl font-semibold mb-2">No Active Blacklist Records</h2>
                    <p>You currently have no active blacklist records in the system.</p>
                </div>
            @else
                @foreach($blacklistStatus as $index => $status)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold mb-0">{{ $status->vehicle }}</h3>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p><strong>Type:</strong> {{ $status->type }}</p>
                            </div>
                            <button class="btn btn-info" onclick="openBlacklistDetailsModal({{ $index }})"><i class="fas fa-eye"></i> View</button>
                        </div>
                    </div>
                @endforeach

                <!-- Blacklist Details Modal -->
                <div class="modal" id="blacklistDetailsModal" tabindex="-1" role="dialog">
                    <div class="modal-content">
                        <span class="close" onclick="closeBlacklistDetailsModal()">&times;</span>
                        <h2>Blacklist Details</h2>
                        <div id="blacklistDetailsContent"></div>
                    </div>
                </div>

                <script>
                    // Prepare all blacklist data in JS
                    const blacklistData = @json($blacklistStatus);

                    function openBlacklistDetailsModal(index) {
                        const data = blacklistData[index];
                        let html = '';
                        html += `<p><strong>Date Added:</strong> ${data.date_added || ''}</p>`;
                        if (data.vehicle) html += `<p><strong>Vehicle:</strong> ${data.vehicle}</p>`;
                        html += `<p><strong>Description:</strong> ${data.description || ''}</p>`;
                        // Violations section
                        if (data.violations && data.violations.length > 0) {
                            html += '<div class="report-details">';
                            html += '<h5>All Violations for this Vehicle</h5>';
                            html += '<ul style="padding-left: 18px;">';
                            data.violations.forEach(function(v) {
                                html += `<li><strong>Code:</strong> ${v.violation_code || ''} <br><strong>Description:</strong> ${v.description || ''} <br><strong>Date:</strong> ${v.violation_date || ''} <br><strong>Status:</strong> ${v.status || ''}</li><hr>`;
                            });
                            html += '</ul>';
                            html += '</div>';
                        }
                        // All pending reports (if any)
                        if (data.pending_reports && data.pending_reports.length > 0) {
                            html += '<div class="report-details">';
                            html += '<h5>All Pending Reports for this Vehicle</h5>';
                            html += '<ul style="padding-left: 18px;">';
                            data.pending_reports.forEach(function(r) {
                                html += `<li><strong>Date:</strong> ${r.date || ''} <br><strong>Location:</strong> ${r.location || ''} <br><strong>Details:</strong> ${r.details || ''}</li><hr>`;
                            });
                            html += '</ul>';
                            html += '</div>';
                        }
                        document.getElementById('blacklistDetailsContent').innerHTML = html;
                        document.getElementById('blacklistDetailsModal').style.display = 'flex';
                    }
                    function closeBlacklistDetailsModal() {
                        document.getElementById('blacklistDetailsModal').style.display = 'none';
                    }
                    // Close modal when clicking outside
                    window.onclick = function(event) {
                        const modal = document.getElementById('blacklistDetailsModal');
                        if (event.target === modal) {
                            closeBlacklistDetailsModal();
                        }
                    }
                </script>
            @endif
        </div>
    </div>
</body>
</html>