<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Generate Violations - Officer</title>
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
        .btn-delete-custom {
            background-color: #ef4444;
            border: 1px solid #dc2626;
            color: white;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-delete-custom:hover {
            background-color: #dc2626;
            border-color: #b91c1c;
        }
        .btn-edit-custom {
            background-color: #3b82f6;
            border: 1px solid #2563eb;
            color: white;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-edit-custom:hover {
            background-color: #2563eb;
            border-color: #1d4ed8;
        }
        .btn-logout-custom {
            border: 2px solid #ef4444;
            background: #fff;
            color: #ef4444;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .btn-logout-custom:hover {
            background: #ef4444;
            color: #fff;
        }
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            min-width: 900px;
            width: 100%;
            table-layout: fixed;
        }
        .table th, .table td {
            white-space: normal;
            vertical-align: middle;
            word-wrap: break-word;
        }
        .table th:nth-child(1),
        .table td:nth-child(1) {
            display: none;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        .status-text {
            margin-left: 10px;
            font-weight: 500;
            color: #28a745;
            transition: opacity 0.3s;
        }
        .status-text.error {
            color: #dc3545;
        }
        .status-text.hidden {
            opacity: 0;
        }
        .nowrap {
            white-space: normal;
            word-wrap: break-word;
        }
        #editViolationModal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        #editViolationModal .modal-content {
            background: #fff;
            margin: 0 auto;
            padding: 32px 28px 24px 28px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            width: 100%;
            max-width: 420px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        #editViolationModal .close {
            position: absolute;
            right: 18px;
            top: 12px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }
        #editViolationModal .close:hover,
        #editViolationModal .close:focus {
            color: #333;
        }
        #editViolationModal .form-group {
            margin-bottom: 18px;
        }
        #editViolationModal .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        #editViolationModal .btn {
            width: 100%;
            padding: 12px 0;
            font-size: 1rem;
            border-radius: 6px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="flex">
        <div class="sidebar">
            <img src="{{ asset('images/image3.png') }}" alt="JME Logo" class="logo">
            <nav>
                <a href="{{ url('/dashboard/officer') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('/issue-violation') }}" class="active" id="sidebarOpenModalBtn"><i class="fas fa-exclamation-triangle"></i> Violation</a>
                <a href="{{ route('reports.index') }}"><i class="fas fa-folder-open"></i> Reports</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-custom"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1>Violations</h1>
            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                <button class="btn" onclick="openGenerateViolationModal()">Generate Violation</button>
            </div>
            <!-- Search Bar -->
            <div class="search-container" style="margin-bottom: 20px; display: flex; align-items: center; justify-content: flex-end;">
                <input type="text" id="violationSearchInput" placeholder="Search..." style="width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 25px; outline: none; transition: border-color 0.3s;">
                <button class="search-button" onclick="filterViolationRecords()" style="background-color: #4CAF50; color: white; border: none; border-radius: 25px; padding: 10px 15px; margin-left: 10px; cursor: pointer; display: flex; align-items: center;">
                    <i class="fas fa-search" style="margin-right: 5px;"></i> Search
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Violation ID</th>
                            <th>Violation Code</th>
                            <th>Description</th>
                            <th>Penalty Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($violations as $violation)
                            <tr data-violation-id="{{ $violation->violation_id }}">
                                <td>{{ $violation->violation_id }}</td>
                                <td>{{ $violation->violation_code }}</td>
                                <td>{{ $violation->description }}</td>
                                <td class="nowrap">₱{{ number_format($violation->penalty_amount, 2) }}</td>
                                <td class="action-buttons-cell"><div class="action-buttons">
                                    <button class="btn-edit-custom" data-id="{{ $violation->violation_id }}"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn-delete-custom" data-id="{{ $violation->violation_id }}"><i class="fas fa-trash"></i> Delete</button>
                                    <span class="status-text hidden" data-id="{{ $violation->violation_id }}"></span>
                                </div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="generateViolationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeGenerateViolationModal()" style="position:absolute; right:15px; top:10px; font-size:28px; font-weight:bold; color:#aaa; cursor:pointer;">×</span>
            <h2>Generate Violation</h2>
            <form id="violationForm" action="{{ route('officer.violation.store') }}" method="POST">
                @csrf
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
                <button type="submit" class="btn">Generate Violation</button>
            </form>
        </div>
    </div>

    <!-- Edit Violation Modal -->
    <div id="editViolationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditViolationModal()">×</span>
            <h2 style="text-align:left; margin-bottom: 20px;">Edit Violation</h2>
            <form id="editViolationForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_violation_id" name="violation_id">
                <div class="form-group">
                    <label for="edit_violation_code">Violation Code:</label>
                    <input type="text" class="form-control" id="edit_violation_code" name="violation_code" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description:</label>
                    <input type="text" class="form-control" id="edit_description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="edit_penalty_amount">Penalty Amount:</label>
                    <input type="number" class="form-control" id="edit_penalty_amount" name="penalty_amount" required>
                </div>
                <button type="submit" class="btn">Update Violation</button>
            </form>
        </div>
    </div>

    <script>
        function openGenerateViolationModal() {
            document.getElementById('generateViolationModal').style.display = 'block';
        }

        function closeGenerateViolationModal() {
            document.getElementById('generateViolationModal').style.display = 'none';
            document.getElementById('violationForm').reset();
        }

        window.onclick = function(event) {
            const generateModal = document.getElementById('generateViolationModal');
            const editModal = document.getElementById('editViolationModal');
            
            if (event.target === generateModal) {
                closeGenerateViolationModal();
            }
            if (event.target === editModal) {
                closeEditViolationModal();
            }
        }

        function validateForm(formData) {
            const errors = [];
            const violationCode = formData.get('violation_code').trim();
            const description = formData.get('description').trim();
            const penaltyAmount = formData.get('penalty_amount');

            if (!/^[a-zA-Z0-9-]{1,10}$/.test(violationCode)) {
                errors.push('Violation Code must be 1-10 characters long and can only contain letters, numbers, and hyphens.');
            }

            if (description.length === 0 || description.length > 255) {
                errors.push('Description is required and must be less than 255 characters.');
            }

            if (isNaN(penaltyAmount) || penaltyAmount <= 0) {
                errors.push('Penalty Amount must be a positive number.');
            }

            return errors;
        }

        function handleViolationSubmit(event) {
            event.preventDefault();

            const form = document.getElementById('violationForm');
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const table = document.getElementById('violationTable').getElementsByTagName('tbody')[0];

            const errors = validateForm(formData);
            if (errors.length > 0) {
                alert('Please fix the following errors:\n- ' + errors.join('\n- '));
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        if (err.message && typeof err.message === 'object') {
                            const errorMessages = Object.values(err.message).flat();
                            throw new Error(errorMessages.join('\n'));
                        }
                        throw new Error(err.message || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const violation = data.violation;
                    const newRow = table.insertRow();
                    newRow.innerHTML = `
                        <td>${violation.violation_id}</td>
                        <td>${violation.violation_code}</td>
                        <td>${violation.description}</td>
                        <td>${violation.penalty_amount}</td>
                        <td class="action-buttons-cell"><div class="action-buttons">
                            <button class="btn-edit-custom" data-id="${violation.violation_id}"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn-delete-custom" data-id="${violation.violation_id}"><i class="fas fa-trash"></i> Delete</button>
                            <span class="status-text hidden" data-id="${violation.violation_id}"></span>
                        </div></td>
                    `;

                    alert(data.message || 'Violation generated successfully!');
                    form.reset();
                    closeGenerateViolationModal();
                } else {
                    alert(data.message || 'Failed to generate violation');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'An error occurred while generating the violation. Please try again.');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Generate Violation';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('violationForm').addEventListener('submit', handleViolationSubmit);

            const table = document.getElementById('violationTable');
            table.addEventListener('click', function(event) {
                const deleteButton = event.target.closest('.btn-delete-custom');
                const editButton = event.target.closest('.btn-edit-custom');
                const statusElement = event.target.closest('td')?.querySelector('.status-text');

                if (deleteButton && statusElement) {
                    const violationId = deleteButton.getAttribute('data-id');
                    statusElement.textContent = 'Deleting...';
                    statusElement.classList.remove('hidden');

                    setTimeout(() => {
                        statusElement.textContent = 'Deleted';
                        statusElement.classList.add('hidden');
                        setTimeout(() => {
                            deleteButton.closest('tr').remove();
                        }, 500);
                    }, 1000);
                }

                if (editButton && statusElement) {
                    const violationId = editButton.getAttribute('data-id');
                    statusElement.textContent = 'Editing...';
                    statusElement.classList.remove('hidden');

                    setTimeout(() => {
                        statusElement.textContent = 'Edited';
                        statusElement.classList.add('hidden');
                    }, 1000);
                }
            });
        });

        document.getElementById('sidebarOpenModalBtn').addEventListener('click', openGenerateViolationModal);

        // Edit Violation Modal Functions
        function openEditViolationModal(violationId) {
            const modal = document.getElementById('editViolationModal');
            const form = document.getElementById('editViolationForm');
            const row = document.querySelector(`tr[data-violation-id="${violationId}"]`);
            
            // Set the form action URL
            form.action = `/dashboard/officer/violation/${violationId}`;
            
            // Fill the form with current values
            document.getElementById('edit_violation_id').value = violationId;
            document.getElementById('edit_violation_code').value = row.querySelector('td:nth-child(2)').textContent;
            document.getElementById('edit_description').value = row.querySelector('td:nth-child(3)').textContent;
            document.getElementById('edit_penalty_amount').value = row.querySelector('td:nth-child(4)').textContent.replace('₱', '').replace(',', '');
            
            modal.style.display = 'flex';
        }

        function closeEditViolationModal() {
            document.getElementById('editViolationModal').style.display = 'none';
            document.getElementById('editViolationForm').reset();
        }

        // Handle Edit Form Submit
        document.getElementById('editViolationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';

            fetch(form.action, {
                method: 'PUT',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`tr[data-violation-id="${formData.get('violation_id')}"]`);
                    row.querySelector('td:nth-child(2)').textContent = data.violation.violation_code;
                    row.querySelector('td:nth-child(3)').textContent = data.violation.description;
                    row.querySelector('td:nth-child(4)').textContent = `₱${parseFloat(data.violation.penalty_amount).toLocaleString()}`;
                    
                    alert(data.message || 'Violation updated successfully!');
                    closeEditViolationModal();
                } else {
                    alert(data.message || 'Failed to update violation');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the violation. Please try again.');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Update Violation';
            });
        });

        // Handle Delete Button Click
        document.querySelectorAll('.btn-delete-custom').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this violation?')) {
                    const violationId = this.getAttribute('data-id');
                    const row = this.closest('tr');
                    const statusElement = row.querySelector('.status-text');
                    
                    statusElement.textContent = 'Deleting...';
                    statusElement.classList.remove('hidden');

                    fetch(`/dashboard/officer/violation/${violationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            statusElement.textContent = 'Deleted';
                            setTimeout(() => {
                                row.remove();
                            }, 500);
                        } else {
                            statusElement.textContent = 'Error';
                            statusElement.classList.add('error');
                            setTimeout(() => {
                                statusElement.classList.add('hidden');
                                statusElement.classList.remove('error');
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusElement.textContent = 'Error';
                        statusElement.classList.add('error');
                        setTimeout(() => {
                            statusElement.classList.add('hidden');
                            statusElement.classList.remove('error');
                        }, 2000);
                    });
                }
            });
        });

        // Handle Edit Button Click
        document.querySelectorAll('.btn-edit-custom').forEach(button => {
            button.addEventListener('click', function() {
                const violationId = this.getAttribute('data-id');
                openEditViolationModal(violationId);
            });
        });

        // Violation Table Search Function
        function filterViolationRecords() {
            const input = document.getElementById('violationSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.table');
            const trs = table.querySelectorAll('tbody tr');
            trs.forEach(tr => {
                const code = tr.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const desc = tr.querySelector('td:nth-child(3)').textContent.toLowerCase();
                if (code.includes(filter) || desc.includes(filter)) {
                    tr.style.display = '';
                } else {
                    tr.style.display = 'none';
                }
            });
        }
        // Enable live search as user types
        document.getElementById('violationSearchInput').addEventListener('keyup', filterViolationRecords);
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>