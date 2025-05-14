@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Report</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('reports.update', $report->report_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="violation_id">Violation:</label>
            <select class="form-control" id="violation_id" name="violation_id" required>
                @foreach($violations as $violation)
                    <option value="{{ $violation->violation_id }}" {{ $report->violation_id == $violation->violation_id ? 'selected' : '' }}>
                        {{ $violation->violation_code }} - {{ $violation->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="own_id">Owner:</label>
            <select class="form-control" id="own_id" name="own_id" required onchange="updateVehicleList(this.value)">
                @foreach($owners as $owner)
                    <option value="{{ $owner->own_id }}" {{ $report->own_id == $owner->own_id ? 'selected' : '' }}>
                        {{ $owner->fname }} {{ $owner->lname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="reg_vehicle_id">Vehicle:</label>
            <select class="form-control" id="reg_vehicle_id" name="reg_vehicle_id" required>
                <option value="{{ $report->reg_vehicle_id }}">
                    {{ $report->vehicle->plate_number }} - {{ $report->vehicle->brand }} {{ $report->vehicle->model }}
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="report_date">Report Date:</label>
            <input type="date" class="form-control" id="report_date" name="report_date" value="{{ $report->report_date->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $report->location }}" required>
        </div>

        <div class="form-group">
            <label for="report_details">Report Details:</label>
            <textarea class="form-control" id="report_details" name="report_details" rows="3" required>{{ $report->report_details }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $report->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $report->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Report</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
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
    .then(response => response.json())
    .then(data => {
        if (Array.isArray(data) && data.length > 0) {
            vehicleSelect.innerHTML = '<option value="" disabled>Select Vehicle</option>';
            data.forEach(vehicle => {
                const option = document.createElement('option');
                option.value = vehicle.reg_vehicle_id;
                option.textContent = `${vehicle.plate_number} - ${vehicle.brand} ${vehicle.model} (${vehicle.vehicle_type})`;
                vehicleSelect.appendChild(option);
            });
            vehicleSelect.disabled = false;
            
            // Select the current vehicle if it belongs to the selected owner
            if (vehicleSelect.querySelector(`option[value="${{{ $report->reg_vehicle_id }}}"]`)) {
                vehicleSelect.value = {{ $report->reg_vehicle_id }};
            }
        } else {
            vehicleSelect.innerHTML = '<option value="" disabled>No vehicles found for this owner</option>';
            vehicleSelect.disabled = true;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        vehicleSelect.innerHTML = '<option value="" disabled>Error loading vehicles</option>';
        vehicleSelect.disabled = true;
    });
}

// Load vehicles for the initial owner on page load
document.addEventListener('DOMContentLoaded', function() {
    const ownerId = document.getElementById('own_id').value;
    if (ownerId) {
        updateVehicleList(ownerId);
    }
});
</script>
@endsection 