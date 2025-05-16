<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\RegisteredVehicle;
use App\Models\Owner;
use App\Models\Report;
use App\Models\Payment;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PayFinesController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.pay.fines');
        } else {
            $userId = Auth::id();

            // Get unpaid violation records
            $violationRecords = ViolationRecord::with(['violation', 'vehicle'])
                ->whereHas('vehicle.owner', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->where('status', 'unpaid')
                ->get()
                ->map(function($record) {
                    return (object)[
                        'id' => $record->record_id,
                        'type' => 'violation',
                        'date' => $record->violation_date,
                        'violation_code' => $record->violation->violation_code,
                        'penalty_amount' => $record->violation->penalty_amount,
                        'vehicle' => $record->vehicle->plate_number . ' - ' . $record->vehicle->brand . ' ' . $record->vehicle->model,
                        'status' => $record->status
                    ];
                });

            // Get unpaid reports
            $reports = Report::with(['violation', 'vehicle'])
                ->whereHas('vehicle.owner', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->where('status', 'pending')
                ->get()
                ->map(function($report) {
                    return (object)[
                        'id' => $report->report_id,
                        'type' => 'report',
                        'date' => $report->report_date,
                        'violation_code' => $report->violation->violation_code,
                        'penalty_amount' => $report->violation->penalty_amount,
                        'vehicle' => $report->vehicle->plate_number . ' - ' . $report->vehicle->brand . ' ' . $report->vehicle->model,
                        'status' => $report->status
                    ];
                });

            // Merge and sort all unpaid records by date
            $fines = $violationRecords->concat($reports)->sortByDesc('date');

            // If there are no unpaid fines, check and resolve any active blacklists
            if ($fines->isEmpty()) {
                // Get all vehicles owned by the user
                $vehicles = RegisteredVehicle::whereHas('owner', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->get();

                foreach ($vehicles as $vehicle) {
                    // Check if this vehicle has any active blacklists
                    $blacklist = Blacklist::where('reg_vehicle_id', $vehicle->reg_vehicle_id)
                        ->where('own_id', $vehicle->own_id)
                        ->where('status', 'Active')
                        ->first();

                    if ($blacklist) {
                        // Double check no unpaid fines for this vehicle
                        $hasUnpaidFines = ViolationRecord::where('reg_vehicle_id', $vehicle->reg_vehicle_id)
                            ->where('status', 'unpaid')
                            ->exists();

                        $hasPendingReports = Report::where('reg_vehicle_id', $vehicle->reg_vehicle_id)
                            ->where('status', 'pending')
                            ->exists();

                        if (!$hasUnpaidFines && !$hasPendingReports) {
                            $blacklist->update([
                                'status' => 'Lifted',
                                'resolution_status' => 'Resolved',
                                'lifted_date' => now(),
                            ]);
                            Log::info("Blacklist automatically lifted for vehicle ID: {$vehicle->reg_vehicle_id}");
                        }
                    }
                }
            }

            return view('guest.payfines', compact('fines'));
        }
    }

    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('pay.fines')->with('error', 'Unauthorized access.');
        }

        // Get all payments with their relationships
        $payments = Payment::with(['payable', 'user'])
            ->orderBy('payment_date', 'desc')
            ->get()
            ->map(function($payment) {
                $payable = $payment->payable;
                $type = class_basename($payment->payable_type);
                
                // Get vehicle and violation details based on payable type
                if ($type === 'ViolationRecord') {
                    $vehicle = $payable->vehicle;
                    $violation = $payable->violation;
                } else { // Report
                    $vehicle = $payable->vehicle;
                    $violation = $payable->violation;
                }

                return (object)[
                    'payment_id' => $payment->payment_id,
                    'date' => $payment->payment_date->format('M d, Y H:i'),
                    'type' => $type,
                    'vehicle' => $vehicle->plate_number . ' - ' . $vehicle->brand . ' ' . $vehicle->model,
                    'violation' => $violation->violation_code,
                    'amount' => $payment->amount_paid,
                    'payment_method' => $payment->payment_method,
                    'transaction_reference' => $payment->transaction_reference,
                    'payer' => $payment->user->fname . ' ' . $payment->user->lname
                ];
            });

        return view('admin.payfines', compact('payments'));
    }

    private function checkUnpaidFines($vehicleId)
    {
        // Check for any unpaid violation records
        $hasUnpaidViolations = ViolationRecord::where('reg_vehicle_id', $vehicleId)
            ->where('status', 'unpaid')
            ->exists();

        // Check for any pending reports
        $hasPendingReports = Report::where('reg_vehicle_id', $vehicleId)
            ->where('status', 'pending')
            ->exists();

        // Return true if there are no unpaid fines
        return !($hasUnpaidViolations || $hasPendingReports);
    }

    private function resolveBlacklist($vehicleId, $ownerId)
    {
        Log::info("Checking blacklist resolution for vehicle ID: {$vehicleId}, owner ID: {$ownerId}");
        
        // Only proceed if there are no unpaid fines
        if ($this->checkUnpaidFines($vehicleId)) {
            $blacklist = Blacklist::where('reg_vehicle_id', $vehicleId)
                ->where('own_id', $ownerId)
                ->where('status', 'Active')
                ->first();

            if ($blacklist) {
                Log::info("No unpaid fines found. Lifting blacklist for vehicle ID: {$vehicleId}");
                
                try {
                    $result = $blacklist->update([
                        'status' => 'Lifted',
                        'lifted_date' => now(),
                    ]);
                    
                    Log::info("Blacklist update result: " . ($result ? "success" : "failed"));
                } catch (\Exception $e) {
                    Log::error("Error updating blacklist: " . $e->getMessage());
                }
            }
        } else {
            Log::info("Vehicle ID {$vehicleId} still has unpaid fines. Blacklist remains active.");
        }
    }

    public function payFine(Request $request, $id)
    {
        $userId = Auth::id();
        Log::info("Processing payment for ID: {$id} by user: {$userId}");

        // Validate payment details
        $validatedData = $request->validate([
            'payment_method' => 'required|in:Credit Card,Debit Card,GCash,Maya',
            'payment_date' => 'required|date|before_or_equal:today',
        ]);

        // Try to find a violation record first
        $violationRecord = ViolationRecord::with('vehicle')->whereHas('vehicle.owner', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->find($id);

        if ($violationRecord) {
            if ($violationRecord->status === 'paid') {
                return redirect()->route('pay.fines')->with('error', 'This fine has already been paid.');
            }

            // Create payment record
            $payment = new Payment([
                'payment_date' => $validatedData['payment_date'],
                'payment_method' => $validatedData['payment_method'],
                'transaction_reference' => Payment::generateTransactionReference(),
                'amount_paid' => $violationRecord->violation->penalty_amount,
                'user_id' => $userId
            ]);

            $violationRecord->payments()->save($payment);
            $violationRecord->update(['status' => 'paid']);

            // Check and resolve blacklist if all fines are paid
            $this->resolveBlacklist($violationRecord->reg_vehicle_id, $violationRecord->vehicle->own_id);

            return redirect()->route('pay.fines')->with('success', 'Fine paid successfully and blacklist status updated if applicable.');
        }

        // If not a violation record, try to find a report
        $report = Report::with('vehicle')->whereHas('vehicle.owner', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->find($id);

        if ($report) {
            if ($report->status === 'paid') {
                return redirect()->route('pay.fines')->with('error', 'This fine has already been paid.');
            }

            // Create payment record
            $payment = new Payment([
                'payment_date' => $validatedData['payment_date'],
                'payment_method' => $validatedData['payment_method'],
                'transaction_reference' => Payment::generateTransactionReference(),
                'amount_paid' => $report->violation->penalty_amount,
                'user_id' => $userId
            ]);

            $report->payments()->save($payment);
            $report->update(['status' => 'paid']);

            // Check and resolve blacklist if all fines are paid
            $this->resolveBlacklist($report->reg_vehicle_id, $report->vehicle->own_id);

            return redirect()->route('pay.fines')->with('success', 'Fine paid successfully and blacklist status updated if applicable.');
        }

        return redirect()->route('pay.fines')->with('error', 'Fine not found.');
    }

    public function guestIndexRecords()
    {
        $records = ViolationRecord::with('violation')
            ->join('registered_vehicles', 'violation_records.reg_vehicle_id', '=', 'registered_vehicles.reg_vehicle_id')
            ->join('owners', 'registered_vehicles.own_id', '=', 'owners.own_id')
            ->where('owners.own_id', Auth::id())
            ->select('violation_records.*')
            ->get();
        return view('guest.violation_history', compact('records'));
    }
}