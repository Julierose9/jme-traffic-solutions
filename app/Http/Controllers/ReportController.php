<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
{
    $reports = Report::all(); 
    return view('officer.reports', compact('reports'));    
}

    public function create()
    {
        return view('create_report'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'violation_id' => 'required|exists:violations,id',
            'officer_id' => 'required|exists:officers,id',
            'reg_vehicle_id' => 'required|exists:vehicles,id',
            'own_id' => 'required|exists:owners,id',
            'report_details' => 'required|string',
            'location' => 'required|string',
            'report_date' => 'required|date',
            'status' => 'required|string',
        ]);

        Report::create($request->all()); // Create a new report

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

}