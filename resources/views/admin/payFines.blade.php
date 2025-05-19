<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay Fines - Admin Dashboard</title>
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

        .badge {
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

        .bg-primary {
            background-color: #0d6efd;
        }

        .bg-info {
            background-color: #0dcaf0;
        }

        .bg-success {
            background-color: #198754;
        }

        .text-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.875em;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table th {
            background-color: #0a1f44;
            color: white;
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .btn-delete-custom {
            border: 2px solid #ef4444;
            background: #fff;
            color: #ef4444;
            border-radius: 12px;
            padding: 6px 18px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .btn-delete-custom:hover {
            background: #ef4444;
            color: #fff;
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

        /* Add search container styles */
        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .search-container input {
            width: 300px;
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

        .nowrap {
            white-space: nowrap;
        }

        .table td {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-view-custom {
            background: #fff;
            border: 2px solid #28a745;
            color: #28a745;
            border-radius: 16px;
            padding: 3px 14px 3px 10px;
            font-size: 0.95rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            box-shadow: none;
        }
        .btn-view-custom i {
            color: #28a745;
            font-size: 1.1em;
            margin-right: 4px;
        }
        .btn-view-custom:hover, .btn-view-custom:focus {
            background: #28a745;
            color: #fff;
            border-color: #28a745;
        }
        .btn-view-custom:hover i, .btn-view-custom:focus i {
            color: #fff;
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
                <a href="{{ route('blacklist.management') }}"><i class="fas fa-ban"></i> Blacklist Management</a>
                <a href="{{ route('admin.pay.fines') }}" class="active"><i class="fas fa-money-bill-wave"></i> Pay Fines</a>
            </nav>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-custom"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <h1 class="text-2xl font-bold mb-4">Payment Records</h1>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterRecords()">
                <button class="search-button" onclick="filterRecords()">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

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

            @if($payments->isEmpty())
                <div class="no-records">
                    <h2>No Payment Records Found</h2>
                    <p>There are no payment records in the system.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Payment Date</th>
                                <th>Type</th>
                                <th>Vehicle</th>
                                <th>Violation</th>
                                <th>Amount Paid</th>
                                <th>Payment Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime($payment->date)) }}</td>
                                    <td>
                                        <span class="badge {{ $payment->type === 'ViolationRecord' ? 'bg-primary' : 'bg-info' }}">
                                            {{ $payment->type === 'ViolationRecord' ? 'Violation' : 'Report' }}
                                        </span>
                                    </td>
                                    <td class="nowrap">{{ $payment->vehicle }}</td>
                                    <td class="nowrap">{{ $payment->violation }}</td>
                                    <td class="nowrap">₱{{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-success nowrap">{{ $payment->payment_method }}</span>
                                    </td>
                                    <td>
                                        <button class="btn-view-custom" onclick="openOwnerDetailsModal('{{ $payment->owner_id ?? ($payment->payable->own_id ?? '') }}', '{{ $payment->transaction_reference }}', '{{ $payment->payer }}')">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="paymentDetailsModalLabel">Payment Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label><strong>Transaction Reference:</strong></label>
              <div id="modalTransactionReference" class="form-control-plaintext"></div>
            </div>
            <div class="form-group">
              <label><strong>Paid By:</strong></label>
              <div id="modalPaidBy" class="form-control-plaintext"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        function toggleDropdown(btn) {
            const dropdown = btn.nextElementSibling;
            dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
        }

        function filterRecords() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('finesTable');
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

        function openOwnerDetailsModal(ownerId, transactionReference, paidBy) {
            document.getElementById('modalTransactionReference').textContent = transactionReference;
            document.getElementById('modalPaidBy').textContent = paidBy;
            $('#paymentDetailsModal').modal('show');
        }
    </script>
</body>
</html>