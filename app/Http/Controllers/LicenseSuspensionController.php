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
        try {
            $validatedData = $request->validate([
                'own_id' => 'required|exists:owners,own_id',
                'suspension_start_date' => 'required|date',
                'suspension_end_date' => 'nullable|date|after_or_equal:suspension_start_date',
                'suspension_reason' => 'required|string|max:255',
                'suspension_status' => 'required|in:Active,Lifted',
                'appeal_status' => 'nullable|in:Pending,Approved,Rejected'
            ]);

            $suspension = LicenseSuspension::create($validatedData);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'License suspension added successfully',
                    'suspension' => $suspension
                ]);
            }

            return redirect()->route('license.suspension')->with('success', 'License suspension added successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add license suspension: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to add license suspension: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'own_id' => 'required|exists:owners,own_id',
                'suspension_start_date' => 'required|date',
                'suspension_end_date' => 'nullable|date|after_or_equal:suspension_start_date',
                'suspension_reason' => 'required|string|max:255',
                'suspension_status' => 'required|in:Active,Lifted',
                'appeal_status' => 'nullable|in:Pending,Approved,Rejected'
            ]);

            $suspension = LicenseSuspension::findOrFail($id);
            $suspension->update($validatedData);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'License suspension updated successfully',
                    'suspension' => $suspension
                ]);
            }

            return redirect()->route('license.suspension')->with('success', 'License suspension updated successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update license suspension: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update license suspension: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $suspension = LicenseSuspension::findOrFail($id);
            $suspension->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'License suspension deleted successfully'
                ]);
            }

            return redirect()->route('license.suspension')->with('success', 'License suspension deleted successfully.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete license suspension: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete license suspension: ' . $e->getMessage());
        }
    }
}