<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        // Only get reports for the logged-in officer
        $reports = Report::where('officer_id', Auth::user()->officer_id)->get();
        return view('officer.reports', compact('reports'));    
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
            'violation_date' => 'required|date',
            'location' => 'required|string',
            'remarks' => 'required|string',
            'status' => 'required|string',
        ]);

        // Automatically set the officer_id to the logged-in user
        $data = $request->all();
        $data['officer_id'] = Auth::user()->officer_id;

        Report::create($data);

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