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

// Guest Dashboard
Route::get('/guest', function () {
    return view('guest.dashboard');
})->name('dashboard.guest');

// Authenticated Routes
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard.admin');

        // Blacklist Management
        Route::get('/blacklist-management', [BlacklistManagementController::class, 'index'])->name('blacklist.management');
        Route::get('/blacklist/create', [BlacklistManagementController::class, 'create'])->name('blacklist.create');
        Route::post('/blacklist', [BlacklistManagementController::class, 'store'])->name('blacklist.store');
        Route::get('/blacklist/{blacklist}/edit', [BlacklistManagementController::class, 'edit'])->name('blacklist.edit');
        Route::put('/blacklist/{blacklist}', [BlacklistManagementController::class, 'update'])->name('blacklist.update');

        // Vehicle Registration
        Route::get('/register-vehicle', [VehicleController::class, 'showRegisterVehicle'])->name('register.vehicle');
        Route::post('/register-owner', [OwnerController::class, 'registerOwner'])->name('register.owner.submit');
        Route::post('/register-vehicle', [VehicleController::class, 'registerVehicle'])->name('register.vehicle.submit');

        // Violation Records
        Route::get('/violation-record', [ViolationRecordController::class, 'index'])->name('violation.record');
        Route::get('/admin/violation-records', [ViolationRecordController::class, 'index'])->name('violation.records');

        // License Suspension
        Route::get('/license-suspension', [LicenseSuspensionController::class, 'index'])->name('license.suspension');
        Route::post('/license-suspension', [LicenseSuspensionController::class, 'store'])->name('license.suspension.store');
        Route::get('/license-suspension/{suspension}/edit', [LicenseSuspensionController::class, 'edit'])->name('license.suspension.edit');
        Route::delete('/license-suspension/{suspension}', [LicenseSuspensionController::class, 'destroy'])->name('license.suspension.destroy');

        // Store Violation
        Route::post('/violation/store', [ViolationController::class, 'store'])->name('violation.store');
    });

    // Officer Routes
    Route::get('/officer', [ViolationController::class, 'index'])->name('dashboard.officer');
    Route::get('/officer/issue-violation', [ViolationController::class, 'create'])->name('officer.violation.issue');
    Route::post('/officer/violation', [ViolationController::class, 'store'])->name('officer.violation.store');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    // Violation History
    Route::get('/violation-history', [ViolationRecordController::class, 'showViolationHistory'])->name('violation.history');

    // Check Violations
    Route::get('/check-violations', [ViolationController::class, 'check'])->name('violations.check');

    // Blacklist Status - Modified to support GET request
    Route::get('/blacklist/status', [BlacklistManagementController::class, 'checkStatus'])->name('blacklist.status');

    // Pay Fines
    Route::get('/pay-fines', [PayFinesController::class, 'index'])->name('pay.fines');
    Route::post('/pay-fines/{id}', [PayFinesController::class, 'payFine'])->name('pay.fines.pay');

    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support.submit');
});