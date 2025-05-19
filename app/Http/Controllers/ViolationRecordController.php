<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\Officer;
use App\Models\Violation;
use App\Models\RegisteredVehicle;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationRecordController extends Controller
{
    public function index()
    {
        $violationRecords = ViolationRecord::with(['registeredVehicle', 'officer', 'violation'])->get()
            ->map(function($record) {
                return (object)[
                    'id' => $record->record_id,
                    'violation_code' => $record->violation->violation_code ?? 'N/A',
                    'description' => $record->violation->description ?? 'N/A',
                    'penalty_amount' => $record->violation->penalty_amount ?? 0,
                    'plate_number' => $record->registeredVehicle->plate_number ?? 'N/A',
                    'violation_date' => $record->violation_date,
                    'status' => $record->status,
                    'vehicle' => $record->registeredVehicle ? [
                        'vehicle_type' => $record->registeredVehicle->vehicle_type,
                        'brand' => $record->registeredVehicle->brand,
                        'model' => $record->registeredVehicle->model,
                        'color' => $record->registeredVehicle->color,
                        'registration_date' => $record->registeredVehicle->registration_date
                    ] : null,
                    'officer' => $record->officer ? [
                        'first_name' => $record->officer->fname,
                        'last_name' => $record->officer->lname
                    ] : null
                ];
            });
        
        // Get reports and transform them to match violation records format
        $reports = Report::with(['violation', 'vehicle', 'owner', 'officer'])->get()
            ->map(function($report) {
                return (object)[
                    'id' => 'R-' . $report->report_id,
                    'violation_code' => $report->violation->violation_code ?? 'N/A',
                    'description' => $report->report_details,
                    'penalty_amount' => $report->violation->penalty_amount ?? 0,
                    'plate_number' => $report->vehicle->plate_number,
                    'violation_date' => $report->report_date,
                    'status' => $report->status,
                    'vehicle' => [
                        'vehicle_type' => $report->vehicle->vehicle_type,
                        'brand' => $report->vehicle->brand,
                        'model' => $report->vehicle->model,
                        'color' => $report->vehicle->color,
                        'registration_date' => $report->vehicle->registration_date
                    ],
                    'officer' => [
                        'first_name' => $report->officer->fname,
                        'last_name' => $report->officer->lname
                    ]
                ];
            });

        // Merge violation records with transformed reports
        $allRecords = $violationRecords->concat($reports);
        
        return view('admin.violationRecords', compact('allRecords'));
    }

    public function showViolationHistory(Request $request)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Get violation records
        $violationRecords = ViolationRecord::with(['violation', 'registeredVehicle', 'officer'])
            ->whereHas('registeredVehicle.owner', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->map(function($record) {
                return (object)[
                    'date' => $record->violation_date,
                    'vehicle' => $record->registeredVehicle->plate_number . ' - ' . 
                               $record->registeredVehicle->brand . ' ' . 
                               $record->registeredVehicle->model,
                    'violation' => $record->violation->violation_code,
                    'location' => $record->location,
                    'officer' => $record->officer->fname . ' ' . $record->officer->lname,
                    'penalty_amount' => $record->violation->penalty_amount ?? 0,
                    'status' => $record->status,
                    'record_id' => $record->record_id,
                    'isReport' => false
                ];
            });

        // Get reports for the same user
        $reports = Report::with(['violation', 'vehicle', 'officer'])
            ->whereHas('vehicle.owner', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->map(function($report) {
                return (object)[
                    'date' => $report->report_date,
                    'vehicle' => $report->vehicle->plate_number . ' - ' . 
                               $report->vehicle->brand . ' ' . 
                               $report->vehicle->model,
                    'violation' => $report->violation->violation_code,
                    'location' => $report->location,
                    'officer' => $report->officer->fname . ' ' . $report->officer->lname,
                    'penalty_amount' => $report->violation->penalty_amount ?? 0,
                    'status' => $report->status,
                    'details' => $report->report_details,
                    'record_id' => $report->report_id,
                    'isReport' => true
                ];
            });

        // Merge and sort records by date
        $allRecords = $violationRecords->concat($reports)->sortByDesc('date');

        return view('guest.violationHistory', compact('allRecords'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            'officer_id' => 'required|exists:officers,officer_id',
            'violation_id' => 'required|exists:violations,violation_id',
            'violation_date' => 'required|date',
            'location' => 'required|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:paid,unpaid',
        ]);

        $violationRecord = ViolationRecord::create($validatedData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Violation record created successfully',
                'data' => $violationRecord
            ]);
        }

        return redirect()->route('violation.record')->with('success', 'Violation record created successfully');
    }

    public function update(Request $request, $id)
    {
        $violationRecord = ViolationRecord::findOrFail($id);

        $validatedData = $request->validate([
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            'officer_id' => 'required|exists:officers,officer_id',
            'violation_id' => 'required|exists:violations,violation_id',
            'violation_date' => 'required|date',
            'location' => 'required|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:paid,unpaid',
        ]);

        $violationRecord->update($validatedData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Violation record updated successfully',
                'data' => $violationRecord
            ]);
        }

        return redirect()->route('violation.record')->with('success', 'Violation record updated successfully');
    }

    public function destroy($id)
    {
        $violationRecord = ViolationRecord::findOrFail($id);
        $violationRecord->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Violation record deleted successfully'
            ]);
        }

        return redirect()->route('violation.record')->with('success', 'Violation record deleted successfully');
    }

    public function show($id)
    {
        try {
            // Find the violation record and eager load the relationships
            $record = ViolationRecord::with(['registeredVehicle', 'officer', 'violation'])
                ->where('record_id', $id)
                ->firstOrFail();

            // Get the vehicle details through the relationship
            $vehicle = $record->registeredVehicle;
            $officer = $record->officer;

            if (!$vehicle) {
                throw new \Exception('Vehicle not found for record ID: ' . $id);
            }

            return response()->json([
                'success' => true,
                'record' => [
                    'vehicle' => [
                        'plate_number' => $vehicle->plate_number,
                        'vehicle_type' => $vehicle->vehicle_type,
                        'brand' => $vehicle->brand,
                        'model' => $vehicle->model,
                        'color' => $vehicle->color,
                        'registration_date' => $vehicle->registration_date ? date('Y-m-d', strtotime($vehicle->registration_date)) : null
                    ],
                    'officer' => [
                        'name' => $officer->lname . ', ' . $officer->fname,
                        'badge_number' => $officer->badge_number ?? 'N/A'
                    ],
                    'violation' => [
                        'code' => $record->violation->violation_code,
                        'description' => $record->violation->description,
                        'penalty_amount' => $record->violation->penalty_amount
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in ViolationRecordController@show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch record details: ' . $e->getMessage()
            ], 500);
        }
    }
}