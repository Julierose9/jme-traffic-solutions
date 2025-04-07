<?php

namespace App\Http\Controllers;

use App\Models\LicenseSuspension;
use App\Models\Owner; // Import the Owner model
use Illuminate\Http\Request;

class LicenseSuspensionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $suspensions = LicenseSuspension::with('owner')->get(); // Eager load the owner relationship
        $owners = Owner::all(); // Retrieve all owners for the modal dropdown
        return view('admin.licenseSuspension', compact('suspensions', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,own_id', // Validate against the owners table
            'suspension_start_date' => 'required|date',
            'suspension_end_date' => 'nullable|date|after_or_equal:suspension_start_date',
            'suspension_reason' => 'required|string|max:255',
            'suspension_status' => 'required|in:active,lifted',
            'appeal_status' => 'nullable|in:pending,approved,rejected',
        ]);

        LicenseSuspension::create($request->all());

        return redirect()->route('suspension.index')->with('success', 'License suspension added successfully.');
    }

    public function edit(LicenseSuspension $suspension)
    {
        $owners = Owner::all(); // Retrieve all owners for the dropdown in the edit view
        return view('admin.licenseSuspensionEdit', compact('suspension', 'owners'));
    }

    public function destroy(LicenseSuspension $suspension)
    {
        $suspension->delete();
        return redirect()->route('suspension.index')->with('success', 'Suspension deleted successfully.');
    }
}