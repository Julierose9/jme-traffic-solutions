<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\ViolationRecord;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    public function index()
    {
        // Get violations issued by the logged-in officer
        $violations = ViolationRecord::where('officer_id', Auth::user()->officer_id)
            ->with(['violation', 'vehicle'])
            ->orderBy('violation_date', 'desc')
            ->get();
            
        // Get violation types for the dropdown
        $violationTypes = Violation::all();
        
        return view('officer.dashboard', compact('violations', 'violationTypes'));
    }

    public function create()
    {
        // Get all violation types for the dropdown
        $violationTypes = Violation::all();
        // Get the logged-in officer's information
        $officer = Auth::user();
        // Get all violations for the table
        $violations = Violation::all();
        return view('officer.issueViolation', compact('violationTypes', 'officer', 'violations'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'violation_id' => 'required|exists:violations,violation_id',
                'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
                'violation_date' => 'required|date',
                'location' => 'required|string',
                'remarks' => 'required|string',
                'status' => 'required|string',
            ]);

            // Automatically set the officer_id to the logged-in user
            $validatedData['officer_id'] = Auth::user()->officer_id;

            $violationRecord = ViolationRecord::create($validatedData);

            return response()->json([
                'success' => true,
                'violation' => $violationRecord->load(['violation', 'vehicle']),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating the violation. Please try again.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $violationRecord = ViolationRecord::where('officer_id', Auth::user()->officer_id)
            ->where('record_id', $id)
            ->firstOrFail();
        
        $violationTypes = Violation::all();
        return view('officer.edit_violation', compact('violationRecord', 'violationTypes'));
    }

    public function update(Request $request, $id)
    {
        $violationRecord = ViolationRecord::where('officer_id', Auth::user()->officer_id)
            ->where('record_id', $id)
            ->firstOrFail();

        $validatedData = $request->validate([
            'violation_id' => 'required|exists:violations,violation_id',
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            'violation_date' => 'required|date',
            'location' => 'required|string',
            'remarks' => 'required|string',
            'status' => 'required|string',
        ]);

        $violationRecord->update($validatedData);

        return redirect()->route('dashboard.officer')->with('success', 'Violation record updated successfully.');
    }

    public function destroy($id)
    {
        $violationRecord = ViolationRecord::where('officer_id', Auth::user()->officer_id)
            ->where('record_id', $id)
            ->firstOrFail();
        
        $violationRecord->delete();

        return redirect()->route('dashboard.officer')->with('success', 'Violation record deleted successfully.');
    }
}