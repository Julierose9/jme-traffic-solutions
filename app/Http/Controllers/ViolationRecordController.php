<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\Officer;
use App\Models\Violation;
use App\Models\RegisteredVehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationRecordController extends Controller
{
    public function index()
    {
        $violationRecords = ViolationRecord::with(['violation', 'registeredVehicle', 'officer'])->get();
        
        // Get reports and transform them to match violation records format
        $reports = \App\Models\Report::with(['violation', 'vehicle', 'owner', 'officer'])->get()
            ->map(function($report) {
                return (object)[
                    'RecordID' => 'R-' . $report->report_id, // Prefix with R to distinguish from violation records
                    'violationCode' => $report->violation->violation_code ?? 'N/A',
                    'Description' => $report->report_details,
                    'PenaltyAmount' => $report->violation->penalty_amount ?? 0,
                    'PlateNumber' => $report->vehicle->plate_number,
                    'OfficerLastName' => $report->officer->lname,
                    'OfficerFirstName' => $report->officer->fname,
                    'ViolationDate' => $report->report_date,
                    'Status' => $report->status,
                    'isReport' => true // Flag to identify reports
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
        $violationRecords = ViolationRecord::whereHas('registeredVehicle', function($query) use ($userId) {
            $query->whereHas('owner', function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        })
        ->with(['violation', 'registeredVehicle', 'officer'])
        ->get()
        ->map(function($record) {
            return (object)[
                'date' => $record->violation_date,
                'vehicle' => $record->registeredVehicle->plate_number . ' - ' . 
                           $record->registeredVehicle->brand . ' ' . 
                           $record->registeredVehicle->model,
                'violation' => $record->violation->violation_name,
                'location' => $record->location,
                'officer' => $record->officer->fname . ' ' . $record->officer->lname,
                'penalty_amount' => $record->PenaltyAmount,
                'status' => $record->Status,
                'details' => null,
                'isReport' => false
            ];
        });

        // Get reports
        $reports = \App\Models\Report::whereHas('vehicle', function($query) use ($userId) {
            $query->whereHas('owner', function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        })
        ->with(['violation', 'vehicle', 'officer'])
        ->get()
        ->map(function($report) {
            return (object)[
                'date' => $report->report_date,
                'vehicle' => $report->vehicle->plate_number . ' - ' . 
                           $report->vehicle->brand . ' ' . 
                           $report->vehicle->model,
                'violation' => $report->violation->violation_name,
                'location' => $report->location,
                'officer' => $report->officer->fname . ' ' . $report->officer->lname,
                'penalty_amount' => $report->violation->penalty_amount ?? 0,
                'status' => $report->status,
                'details' => $report->report_details,
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
}