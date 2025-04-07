<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::all(); // Fetch all violations
        return view('officer.dashboard', compact('violations')); // Pass violations to the dashboard view
    }

    public function create()
    {
        $violationRecords = Violation::all(); // Adjust this line based on your actual model and data structure
        return view('officer.issueViolation', compact('violationRecords')); // Pass the records to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'violation_code' => 'required',
            'description' => 'required|string|max:255',
            'penalty_amount' => 'required|numeric',
            'plate_number' => 'required|string|max:10',
        ]);

        Violation::create([
            'violation_code' => $request->violation_code,
            'description' => $request->description,
            'penalty_amount' => $request->penalty_amount,
            'plate_number' => $request->plate_number,
        ]);
        // Create a new violation record
         Violation::create($validatedData);

        return redirect()->route('officer.violation.issue')->with('success', 'Violation issued successfully.');
    }
}