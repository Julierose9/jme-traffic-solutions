<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ViolationRecordController;
use App\Http\Controllers\BlacklistManagementController;
use App\Http\Controllers\LicenseSuspensionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PayFinesController; 
use App\Http\Controllers\SupportController;
use App\Http\Controllers\VehicleRegistrationRequestController;
use App\Models\RegisteredVehicle;
use App\Models\Owner;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Guest Routes
Route::middleware(['auth'])->group(function () {
// Guest Dashboard
    Route::get('/guest', [VehicleController::class, 'showGuestDashboard'])->name('dashboard.guest');

    // Guest Violation History
    Route::get('/violation-history', [ViolationRecordController::class, 'showViolationHistory'])->name('violation.history');

    // Guest Pay Fines
    Route::get('/pay-fines', [PayFinesController::class, 'index'])->name('pay.fines');
    Route::post('/pay-fines/{id}', [PayFinesController::class, 'payFine'])->name('pay.fines.pay');

    // Guest Blacklist Status
    Route::get('/blacklist/status', [BlacklistManagementController::class, 'checkStatus'])->name('blacklist.status');

    // Guest Support
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support.submit');

    // Guest vehicle registration request route
    Route::post('/request-vehicle-registration', [VehicleRegistrationRequestController::class, 'store'])
        ->middleware(['auth'])
        ->name('request.vehicle.registration');
});

// Admin Routes
Route::prefix('dashboard/admin')->middleware(['web', 'auth'])->group(function () {
        Route::get('/', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access');
        }
            return view('admin.dashboard');
        })->name('dashboard.admin');

    // Vehicle Registration Requests
    Route::controller(VehicleRegistrationRequestController::class)->group(function () {
        Route::get('/vehicle-registration-requests', 'index')->name('vehicle.registration.requests');
        Route::post('/vehicle-registration-requests/{id}/approve', 'approve')->name('vehicle.registration.approve');
        Route::post('/vehicle-registration-requests/{id}/reject', 'reject')->name('vehicle.registration.reject');
    });

    // Vehicle Registration Management
    Route::controller(VehicleController::class)->group(function () {
        Route::get('/register-vehicle', 'showRegisterVehicle')->name('register.vehicle');
        Route::post('/register-vehicle', 'registerVehicle')->name('register.vehicle.submit');
        Route::get('/vehicles/{id}/edit', 'getVehicleDetails')->name('vehicle.details');
        Route::put('/vehicles/edit', 'update')->name('edit.vehicle.submit');
        Route::delete('/vehicles/delete', 'destroy')->name('delete.vehicle.submit');
    });

        // Violation Records
    Route::controller(ViolationRecordController::class)->group(function () {
        Route::get('/violation-records', 'index')->name('violation.record');
        Route::get('/violation-records/create', 'create')->name('violation.records.create');
        Route::post('/violation-records', 'store')->name('violation.records.store');
    });

    // Blacklist Management
    Route::controller(BlacklistManagementController::class)->group(function () {
        Route::get('/blacklist-management', 'index')->name('blacklist.management');
        Route::get('/blacklist/create', 'create')->name('blacklist.create');
        Route::post('/blacklist', 'store')->name('blacklist.store');
        Route::get('/blacklist/{id}/edit', 'edit')->name('blacklist.edit');
        Route::put('/blacklist/{id}', 'update')->name('blacklist.update');
        Route::delete('/blacklist/{id}', 'destroy')->name('blacklist.destroy');
    });

        // License Suspension
    Route::controller(LicenseSuspensionController::class)->group(function () {
        Route::get('/license-suspension', 'index')->name('license.suspension');
        Route::post('/license-suspension', 'store')->name('license.suspension.store');
        Route::put('/license-suspension/{id}', 'update')->name('license.suspension.update');
        Route::delete('/license-suspension/{id}', 'destroy')->name('license.suspension.destroy');
    });

    // Pay Fines
    Route::get('/pay-fines', [PayFinesController::class, 'adminIndex'])->name('admin.pay.fines');
    });

    // Officer Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/officer', [ViolationController::class, 'index'])->name('dashboard.officer');
    Route::get('/officer/issue-violation', [ViolationController::class, 'create'])->name('officer.violation.issue');
    Route::post('/officer/violation', [ViolationController::class, 'store'])->name('officer.violation.store');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
});

// Add route for fetching vehicles by owner
Route::get('/api/owner/{ownerId}/vehicles', function ($ownerId) {
    try {
        // First check if owner exists
        $owner = Owner::findOrFail($ownerId);

        $vehicles = RegisteredVehicle::where('own_id', $ownerId)
            ->get()
            ->map(function ($vehicle) {
                return [
                    'reg_vehicle_id' => $vehicle->reg_vehicle_id,
                    'plate_number' => $vehicle->plate_number,
                    'brand' => $vehicle->brand,
                    'model' => $vehicle->model,
                    'vehicle_type' => $vehicle->vehicle_type,
                    'color' => $vehicle->color
                ];
            });

        // Always return an array, even if empty
        return response()->json($vehicles);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Owner not found'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to fetch vehicles: ' . $e->getMessage()
        ], 500);
    }
})->middleware('auth');

// One-time migration route to create ViolationRecords for existing Reports
Route::get('/admin/migrate-reports-to-violation-records', function () {
    $count = 0;
    $reports = \App\Models\Report::whereNull('violation_record_id')->get();
    foreach ($reports as $report) {
        $violationRecord = \App\Models\ViolationRecord::create([
            'reg_vehicle_id' => $report->reg_vehicle_id,
            'officer_id' => $report->officer_id,
            'violation_id' => $report->violation_id,
            'violation_date' => $report->report_date,
            'location' => $report->location,
            'remarks' => $report->report_details,
            'status' => 'unpaid',
        ]);
        $report->violation_record_id = $violationRecord->record_id;
        $report->save();
        $count++;
    }
    return "Migrated $count reports to violation records.";
});