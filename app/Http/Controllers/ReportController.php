<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\RegisteredVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get or create the officer record
            $officer = \App\Models\Officer::firstOrCreate(
                ['email' => $user->email],
                [
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'rank' => 'Officer', // Default rank
                    'contact_num' => '0000000000' // Default contact number
                ]
            );

            // Get reports for the logged-in officer with relationships
            $reports = Report::where('officer_id', $officer->officer_id)
                ->with(['violation', 'vehicle', 'owner'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            return view('officer.reports', compact('reports'));    
        } catch (\Exception $e) {
            \Log::error('Error fetching reports: ' . $e->getMessage());
            return view('officer.reports')->withErrors(['error' => 'Error fetching reports. Please try again.']);
        }
    }

    public function create()
    {
        return view('create_report'); 
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user->isOfficer()) {
                throw new \Exception('Only officers can create reports.');
            }

            // Get or create the officer record using the email
            $officer = \App\Models\Officer::firstOrCreate(
                ['email' => $user->email],
                [
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'rank' => 'Officer', // Default rank
                    'contact_num' => '0000000000' // Default contact number
                ]
            );

            $request->validate([
                'violation_id' => 'required|exists:violations,violation_id',
                'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
                'own_id' => 'required|exists:owners,own_id',
                'report_details' => 'required|string|max:65535',
                'location' => 'required|string|max:255',
                'report_date' => 'required|date',
                'status' => 'required|string',
            ]);

            // Create the report
            $report = Report::create([
                'violation_id' => $request->violation_id,
                'officer_id' => $officer->officer_id,
                'reg_vehicle_id' => $request->reg_vehicle_id,
                'own_id' => $request->own_id,
                'report_details' => $request->report_details,
                'location' => $request->location,
                'report_date' => $request->report_date,
                'status' => $request->status
            ]);

            // Check for unpaid violations
            $unpaidCount = Report::where('reg_vehicle_id', $request->reg_vehicle_id)
                ->where('status', 'pending')
                ->count();

            // If there are more than 3 unpaid violations, create a blacklist entry
            if ($unpaidCount >= 3) {
                $vehicle = \App\Models\RegisteredVehicle::with('owner')->find($request->reg_vehicle_id);
                
                // Check if vehicle is not already blacklisted
                $existingBlacklist = \App\Models\Blacklist::where('reg_vehicle_id', $request->reg_vehicle_id)
                    ->where('status', 'Active')
                    ->first();

                if (!$existingBlacklist) {
                    $description = "Multiple Unpaid Violations ({$unpaidCount})";
                    \App\Models\Blacklist::create([
                        'report_id' => $report->report_id,
                        'reg_vehicle_id' => $request->reg_vehicle_id,
                        'own_id' => $request->own_id,
                        'reason' => $description, // Set the reason same as description
                        'blacklist_type' => 'Violation-Based',
                        'description' => $description,
                        'date_added' => now(),
                        'resolution_status' => 'Pending',
                        'status' => 'Active'
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Report created successfully' . ($unpaidCount >= 3 ? ' and vehicle has been blacklisted due to multiple unpaid violations.' : ''),
                'report' => $report->load(['violation', 'vehicle', 'owner'])
            ]);

        } catch (\Exception $e) {
            \Log::error('Report creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::user();
            
            // Get or create the officer record
            $officer = \App\Models\Officer::firstOrCreate(
                ['email' => $user->email],
                [
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'rank' => 'Officer',
                    'contact_num' => '0000000000'
                ]
            );

            // Get the report with relationships
            $report = Report::where('officer_id', $officer->officer_id)
                ->where('report_id', $id)
                ->with(['violation', 'vehicle', 'owner'])
                ->firstOrFail();

            // Return JSON response with owner and vehicle details
            return response()->json([
                'violation_id' => $report->violation_id,
                'own_id' => $report->own_id,
                'owner' => [
                    'fname' => $report->owner->fname,
                    'lname' => $report->owner->lname
                ],
                'reg_vehicle_id' => $report->reg_vehicle_id,
                'vehicle' => [
                    'plate_number' => $report->vehicle->plate_number,
                    'brand' => $report->vehicle->brand,
                    'model' => $report->vehicle->model
                ],
                'report_date' => $report->report_date->format('Y-m-d'),
                'location' => $report->location,
                'report_details' => $report->report_details,
                'status' => $report->status
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Report not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            // Get or create the officer record
            $officer = \App\Models\Officer::firstOrCreate(
                ['email' => $user->email],
                [
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'rank' => 'Officer',
                    'contact_num' => '0000000000'
                ]
            );

            // Find the report
            $report = Report::where('officer_id', $officer->officer_id)
                ->where('report_id', $id)
                ->firstOrFail();

            // Validate the request
            $validatedData = $request->validate([
                'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
                'own_id' => 'required|exists:owners,own_id',
                'report_details' => 'required|string|max:65535',
                'location' => 'required|string|max:255',
                'report_date' => 'required|date',
                'status' => 'required|string',
            ]);

            // Update the report
            $report->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Report updated successfully',
                'report' => $report->load(['violation', 'vehicle', 'owner'])
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            
            // Get or create the officer record
            $officer = \App\Models\Officer::firstOrCreate(
                ['email' => $user->email],
                [
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'rank' => 'Officer',
                    'contact_num' => '0000000000'
                ]
            );

            // Find and delete the report
            $report = Report::where('officer_id', $officer->officer_id)
                ->where('report_id', $id)
                ->firstOrFail();

            $report->delete();

            return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'Failed to delete report.');
        }
    }
}