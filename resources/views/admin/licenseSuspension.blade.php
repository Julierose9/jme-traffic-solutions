<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>License Suspension - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .modal-content button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #45a049;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
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
<<<<<<< HEAD
                <a href="{{ route('admin.pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
                <a href="{{ route('license.suspension') }}"><i class="fas fa-ban"></i> License Suspension</a>
=======
                <a href="{{ route('pay.fines') }}"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
                <a href="{{ route('license.suspension') }}" class="active"><i class="fas fa-ban"></i> License Suspension</a>
>>>>>>> master-copyOne
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <h1>License Suspension Management</h1>
            <button class="btn" id="openModalBtn">Add New Suspension</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>Suspension ID</th>
                        <th>Owner Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Appeal Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($suspensions->isEmpty())
                        <tr>
                            <td colspan="8" class="no-records">No license suspensions found.</td>
                        </tr>
                    @else
                        @foreach($suspensions as $suspension)
                            <tr>
                                <td>{{ $suspension->suspension_id }}</td>
                                <td>{{ $suspension->owner->lname }}, {{ $suspension->owner->fname }}</td>
                                <td>{{ $suspension->suspension_start_date->format('Y-m-d') }}</td>
                                <td>{{ $suspension->suspension_end_date ? $suspension->suspension_end_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $suspension->suspension_reason }}</td>
                                <td>{{ $suspension->suspension_status }}</td>
                                <td>{{ $suspension->appeal_status ?? 'N/A' }}</td>
                                <td class="action-buttons">
                                    <button class="edit-btn" onclick="openEditModal({{ $suspension }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="delete-btn" onclick="deleteSuspension({{ $suspension->suspension_id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <h2>Add New License Suspension</h2>
            <form id="addSuspensionForm" action="{{ route('license.suspension.store') }}" method="POST">
                @csrf
                <div>
                    <label for="own_id">Owner:</label>
                    <select name="own_id" id="own_id" required>
                        <option value="" disabled selected>Select Owner</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->own_id }}">{{ $owner->lname }}, {{ $owner->fname }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="suspension_start_date">Start Date:</label>
                    <input type="date" name="suspension_start_date" id="suspension_start_date" required>
                </div>
                <div>
                    <label for="suspension_end_date">End Date:</label>
                    <input type="date" name="suspension_end_date" id="suspension_end_date">
                </div>
                <div>
                    <label for="suspension_reason">Reason:</label>
                    <input type="text" name="suspension_reason" id="suspension_reason" required>
                </div>
                <div>
                    <label for="suspension_status">Status:</label>
                    <select name="suspension_status" id="suspension_status" required>
                        <option value="Active">Active</option>
                        <option value="Lifted">Lifted</option>
                    </select>
                </div>
                <div>
                    <label for="appeal_status">Appeal Status:</label>
                    <select name="appeal_status" id="appeal_status">
                        <option value="">None</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <button type="submit">Add Suspension</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModalBtn">&times;</span>
            <h2>Edit License Suspension</h2>
            <form id="editSuspensionForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_suspension_id" name="suspension_id">
                <div>
                    <label for="edit_own_id">Owner:</label>
                    <select name="own_id" id="edit_own_id" required>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->own_id }}">{{ $owner->lname }}, {{ $owner->fname }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="edit_suspension_start_date">Start Date:</label>
                    <input type="date" name="suspension_start_date" id="edit_suspension_start_date" required>
                </div>
                <div>
                    <label for="edit_suspension_end_date">End Date:</label>
                    <input type="date" name="suspension_end_date" id="edit_suspension_end_date">
                </div>
                <div>
                    <label for="edit_suspension_reason">Reason:</label>
                    <input type="text" name="suspension_reason" id="edit_suspension_reason" required>
                </div>
                <div>
                    <label for="edit_suspension_status">Status:</label>
                    <select name="suspension_status" id="edit_suspension_status" required>
                        <option value="Active">Active</option>
                        <option value="Lifted">Lifted</option>
                    </select>
                </div>
                <div>
                    <label for="edit_appeal_status">Appeal Status:</label>
                    <select name="appeal_status" id="edit_appeal_status">
                        <option value="">None</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <button type="submit">Update Suspension</button>
            </form>
        </div>
    </div>

    <script>
        // Modal handling
        var modal = document.getElementById("myModal");
        var editModal = document.getElementById("editModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];
        var editSpan = document.getElementsByClassName("close")[1];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        editSpan.onclick = function() {
            editModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }

        // Form submissions
        document.getElementById('addSuspensionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to add suspension');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the suspension. Please try again.');
            });
        });

        function openEditModal(suspension) {
            document.getElementById('edit_suspension_id').value = suspension.suspension_id;
            document.getElementById('edit_own_id').value = suspension.own_id;
            document.getElementById('edit_suspension_start_date').value = suspension.suspension_start_date;
            document.getElementById('edit_suspension_end_date').value = suspension.suspension_end_date || '';
            document.getElementById('edit_suspension_reason').value = suspension.suspension_reason;
            document.getElementById('edit_suspension_status').value = suspension.suspension_status;
            document.getElementById('edit_appeal_status').value = suspension.appeal_status || '';
            
            document.getElementById('editSuspensionForm').action = `{{ url('dashboard/admin/license-suspension') }}/${suspension.suspension_id}`;
            editModal.style.display = "block";
        }

        document.getElementById('editSuspensionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to update suspension');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the suspension. Please try again.');
            });
        });

        function deleteSuspension(suspensionId) {
            if (confirm('Are you sure you want to delete this suspension?')) {
                fetch(`{{ url('dashboard/admin/license-suspension') }}/${suspensionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to delete suspension');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the suspension. Please try again.');
                });
            }
        }
    </script>
</body>
</html>
