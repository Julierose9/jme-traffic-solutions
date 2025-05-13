<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\Officer;
use App\Models\Violation;
use App\Models\RegisteredVehicle;
use Illuminate\Http\Request;

class ViolationRecordController extends Controller
{
    public function index()
    {
        $violationRecords = ViolationRecord::with(['violation', 'registeredVehicle', 'officer'])->get();
        return view('admin.violationRecords', compact('violationRecords'));
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