<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reports - Officer</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background-color: #edf2f7;
    margin: 0; /* Ensure no default margin prevents scrolling */
    height: 100%; /* Allow body to expand with content */
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
    overflow-y: auto; /* Allow sidebar to scroll if content overflows */
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
    box-sizing: border-box;
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
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.table th, .table td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 12px;
    vertical-align: middle;
}

.table th {
    background-color: #0a1f44;
    color: white;
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

.btn-logout-custom:hover {
    background-color: #ef4444 !important;
    color: #fff !important;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    padding: 20px;
    overflow-y: auto; /* Allow modal to scroll if content overflows */
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 700px;
    border-radius: 5px;
    max-height: 80vh; /* Limit modal height to 80% of viewport */
    overflow-y: auto; /* Enable scrolling within modal content */
}

.close {
    color: #aaa;
    position: absolute;
    right: 15px;
    top: 10px;
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

.modal-header h2 {
    font-size: 1.5rem;
    margin: 0 0 20px 0;
    color: #333;
    font-weight: 500;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-grid div {
    margin-bottom: 0;
}

.form-grid label {
    display: block;
    margin-bottom: 5px;
}

.form-grid input,
.form-grid select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
}

.form-grid input:focus,
.form-grid select:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

.form-grid .section-title {
    grid-column: 1 / -1;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
    }
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
}

form button {
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    width: 100%;
    grid-column: 1 / -1;
}

form button:hover {
    background-color: #218838;
}

.btn-submit {
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    width: 100%;
}

.btn-submit:hover {
    background-color: #218838;
}

.btn-edit-custom, .btn-delete-custom, .btn-view-custom {
    height: 35px;
    min-width: 90px;
    font-size: 0.9rem;
    border-radius: 12px;
    padding: 0 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.btn-edit-custom {
    background-color: #3b82f6;
    border: 1px solid #2563eb;
    color: white;
}

.btn-edit-custom:hover {
    background-color: #2563eb;
    border-color: #1d4ed8;
}

.btn-delete-custom {
    background-color: #ef4444;
    border: 1px solid #dc2626;
    color: white;
}

.btn-delete-custom:hover {
    background-color: #dc2626;
    border-color: #b91c1c;
}

.btn-edit-custom i, .btn-delete-custom i {
    margin-right: 5px;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.modal-body {
    padding: 0;
}

.table td .btn {
    margin-right: 5px;
}

.table td form {
    margin: 0;
    padding: 0;
}

.table-responsive {
    /* No forced scrollbars */
}

.table {
    min-width: 900px;
}

.table th, .table td {
    white-space: nowrap;
    vertical-align: middle;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.nowrap {
    white-space: nowrap;
}

.status-badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.status-pending {
    background-color: #ef4444;
}

.status-paid {
    background-color: #10b981;
}

.btn-view-custom {
    border: 2px solid #22c55e;
    background: #fff;
    color: #22c55e;
    transition: background 0.2s, color 0.2s;
}

.btn-view-custom:hover {
    background: #22c55e;
    color: #fff;
}
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
        <nav>
            <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('officer.violation.issue') }}"><i class="fas fa-exclamation-triangle"></i> Violations</a>
            <a href="{{ route('reports.index') }}" class="active"><i class="fas fa-folder-open"></i> Reports</a>
        </nav>
        <div class="logout-btn">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout-custom"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="container mt-5">
            <h1 class="mb-4">My Reports</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                <button class="btn" onclick="openCreateReportModal()">Create Report</button>
            </div>
            <!-- Search Bar -->
            <div class="search-container" style="margin-bottom: 20px; display: flex; align-items: center; justify-content: flex-end;">
                <input type="text" id="reportSearchInput" placeholder="Search..." style="width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 25px; outline: none; transition: border-color 0.3s;">
                <button class="search-button" onclick="filterReportRecords()" style="background-color: #4CAF50; color: white; border: none; border-radius: 25px; padding: 10px 15px; margin-left: 10px; cursor: pointer; display: flex; align-items: center;">
                    <i class="fas fa-search" style="margin-right: 5px;"></i> Search
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Violation</th>
                            <th>Vehicle</th>
                            <th>Owner</th>
                            <th>Report Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports->reverse() as $report)
                            <tr>
                                <td>{{ $report->violation->violation_code }}</td>
                                <td class="nowrap">{{ $report->vehicle->plate_number }}</td>
                                <td class="nowrap">{{ $report->owner->fname }} {{ $report->owner->lname }}</td>
                                <td class="nowrap">{{ $report->report_date->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($report->status) }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <button class="btn-view-custom" 
                                        data-location="{{ $report->location }}" 
                                        data-details="{{ $report->report_details }}"
                                        onclick="openViewReportModal(this)">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn-edit-custom" onclick="openEditReportModal({{ $report->report_id }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-custom">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="createReportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateReportModal()">×</span>
            <h2>Create Report</h2>
            <form id="reportForm" action="{{ route('reports.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="violation_id">Violation:</label>
                            <select class="form-control" id="violation_id" name="violation_id" required>
                                <option value="" disabled selected>Select Violation</option>
                                @foreach(\App\Models\Violation::all() as $violation)
                                    <option value="{{ $violation->violation_id }}">{{ $violation->violation_code }} - {{ $violation->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="officer_name">Officer:</label>
                            <input type="text" class="form-control" id="officer_name" value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="own_id">Owner:</label>
                            <select class="form-control" id="own_id" name="own_id" required onchange="updateVehicleList(this.value)">
                                <option value="" disabled selected>Select Owner</option>
                                @foreach(\App\Models\Owner::whereHas('registeredVehicles')->get() as $owner)
                                    <option value="{{ $owner->own_id }}">
                                        {{ $owner->fname }} {{ $owner->lname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reg_vehicle_id">Vehicle:</label>
                            <select class="form-control" id="reg_vehicle_id" name="reg_vehicle_id" required disabled>
                                <option value="" disabled selected>Select Owner First</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="report_date">Report Date:</label>
                            <input type="date" class="form-control" id="report_date" name="report_date" required value="2025-05-18">
                        </div>
                        <div class="form-group">
                            <label for="location">Location:</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="report_details">Report Details:</label>
                            <textarea class="form-control" id="report_details" name="report_details" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit">Submit Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editReportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditReportModal()">×</span>
            <h2>Edit Report</h2>
            <form id="editReportForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_owner_name">Owner:</label>
                            <input type="text" class="form-control" id="edit_owner_name" disabled>
                            <input type="hidden" id="edit_own_id" name="own_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_vehicle_info">Vehicle:</label>
                            <input type="text" class="form-control" id="edit_vehicle_info" disabled>
                            <input type="hidden" id="edit_reg_vehicle_id" name="reg_vehicle_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_report_date">Report Date:</label>
                            <input type="date" class="form-control" id="edit_report_date" name="report_date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_location">Location:</label>
                            <input type="text" class="form-control" id="edit_location" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_report_details">Report Details:</label>
                            <textarea class="form-control" id="edit_report_details" name="report_details" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit" style="width: 100%; grid-column: 1 / -1;">Update Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- View Report Modal -->
    <div id="viewReportModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <span class="close" onclick="closeViewReportModal()">×</span>
            <h2 style="margin-bottom: 20px;">Report Details</h2>
            <div class="form-group">
                <label><strong>Location:</strong></label>
                <div id="viewReportLocation" style="margin-bottom: 12px;"></div>
            </div>
            <div class="form-group">
                <label><strong>Details:</strong></label>
                <div id="viewReportDetails"></div>
            </div>
        </div>
    </div>

    <script>
        function openCreateReportModal() {
            document.getElementById('createReportModal').style.display = 'block';
        }

        function closeCreateReportModal() {
            document.getElementById('createReportModal').style.display = 'none';
        }

        function openEditReportModal(reportId) {
            const modal = document.getElementById('editReportModal');
            const form = document.getElementById('editReportForm');
            modal.style.display = 'block';
            form.action = `/dashboard/reports/${reportId}`;
            fetch(`/dashboard/reports/${reportId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch report data');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_own_id').value = data.own_id;
                document.getElementById('edit_owner_name').value = `${data.owner.fname} ${data.owner.lname}`;
                document.getElementById('edit_reg_vehicle_id').value = data.reg_vehicle_id;
                document.getElementById('edit_vehicle_info').value = `${data.vehicle.plate_number} - ${data.vehicle.brand} ${data.vehicle.model}`;
                document.getElementById('edit_report_date').value = data.report_date;
                document.getElementById('edit_location').value = data.location;
                document.getElementById('edit_report_details').value = data.report_details;
                document.getElementById('edit_status').value = data.status;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading report data');
                closeEditReportModal();
            });
        }

        function closeEditReportModal() {
            document.getElementById('editReportModal').style.display = 'none';
        }

        function handleReportSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('reportForm');
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to create report');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the report');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editReportForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to update report');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the report');
                });
            });
            document.getElementById('reportForm').addEventListener('submit', handleReportSubmit);
            document.getElementById('location').removeAttribute('readonly');
            document.getElementById('report_details').removeAttribute('readonly');
        });

        function updateVehicleList(ownerId) {
            const vehicleSelect = document.getElementById('reg_vehicle_id');
            vehicleSelect.disabled = true;
            vehicleSelect.innerHTML = '<option value="" disabled selected>Loading vehicles...</option>';
            fetch(`/api/owner/${ownerId}/vehicles`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json().then(data => {
                    console.log('Response data:', data);
                    if (!response.ok) {
                        throw new Error(data.error || `HTTP error! status: ${response.status}`);
                    }
                    return data;
                });
            })
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    vehicleSelect.innerHTML = '<option value="" disabled selected>Select Vehicle</option>';
                    data.forEach(vehicle => {
                        const option = document.createElement('option');
                        option.value = vehicle.reg_vehicle_id;
                        option.textContent = `${vehicle.plate_number} - ${vehicle.brand} ${vehicle.model} (${vehicle.vehicle_type})`;
                        vehicleSelect.appendChild(option);
                    });
                    vehicleSelect.disabled = false;
                } else if (data.message) {
                    vehicleSelect.innerHTML = `<option value="" disabled selected>${data.message}</option>`;
                    vehicleSelect.disabled = true;
                } else {
                    vehicleSelect.innerHTML = '<option value="" disabled selected>No vehicles found for this owner</option>';
                    vehicleSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                vehicleSelect.innerHTML = '<option value="" disabled selected>Error loading vehicles. Please try again.</option>';
                vehicleSelect.disabled = true;
            });
        }

        window.onclick = function(event) {
            const createModal = document.getElementById('createReportModal');
            const editModal = document.getElementById('editReportModal');
            const viewModal = document.getElementById('viewReportModal');
            if (event.target === createModal) {
                closeCreateReportModal();
            } else if (event.target === editModal) {
                closeEditReportModal();
            } else if (event.target === viewModal) {
                closeViewReportModal();
            }
        }

        // View Report Modal Functions
        function openViewReportModal(btn) {
            document.getElementById('viewReportLocation').textContent = btn.getAttribute('data-location');
            document.getElementById('viewReportDetails').textContent = btn.getAttribute('data-details');
            document.getElementById('viewReportModal').style.display = 'block';
        }
        function closeViewReportModal() {
            document.getElementById('viewReportModal').style.display = 'none';
        }

        // Report Table Search Function
        function filterReportRecords() {
            const input = document.getElementById('reportSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.table');
            const trs = table.querySelectorAll('tbody tr');
            trs.forEach(tr => {
                // Search in violation code, vehicle, owner, status
                const violation = tr.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const vehicle = tr.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const owner = tr.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const status = tr.querySelector('td:nth-child(5)').textContent.toLowerCase();
                if (
                    violation.includes(filter) ||
                    vehicle.includes(filter) ||
                    owner.includes(filter) ||
                    status.includes(filter)
                ) {
                    tr.style.display = '';
                } else {
                    tr.style.display = 'none';
                }
            });
        }
        // Enable live search as user types
        document.getElementById('reportSearchInput').addEventListener('keyup', filterReportRecords);
    </script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>