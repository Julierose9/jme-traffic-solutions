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
        // Get reports for the logged-in officer with relationships
        $reports = Report::where('officer_id', Auth::user()->officer_id)
            ->with(['violation', 'vehicle', 'owner'])
            ->get();
            
        // Get all owners for the dropdown
        $owners = \App\Models\Owner::with('user')->get();
        
        return view('officer.reports', compact('reports', 'owners'));    
    }

    public function create()
    {
        return view('create_report'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'violation_id' => 'required|exists:violations,violation_id',
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            'own_id' => 'required|exists:owners,own_id',
            'report_details' => 'required|string',
            'location' => 'required|string',
            'report_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Prepare the data
        $data = $request->all();
        $data['officer_id'] = Auth::user()->officer_id;

        $report = Report::create($data);

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function edit($id)
    {
        $report = Report::where('officer_id', Auth::user()->officer_id)
                       ->where('report_id', $id)
                       ->firstOrFail();
        return view('officer.edit_report', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::where('officer_id', Auth::user()->officer_id)
                       ->where('report_id', $id)
                       ->firstOrFail();

        $request->validate([
            'violation_id' => 'required|exists:violations,violation_id',
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            'violation_date' => 'required|date',
            'location' => 'required|string',
            'remarks' => 'required|string',
            'status' => 'required|string',
        ]);

        $report->update($request->all());

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $report = Report::where('officer_id', Auth::user()->officer_id)
                       ->where('report_id', $id)
                       ->firstOrFail();
        
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}