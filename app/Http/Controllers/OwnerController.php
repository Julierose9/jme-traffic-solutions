<?php
namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function registerOwner(Request $request)
    {
        try {
            $validated = $request->validate([
                'lname' => 'required|string|max:255',
                'fname' => 'required|string|max:255',
                'mname' => 'nullable|string|max:255',
                'address' => 'required|string|max:255',
                'contact_num' => 'required|string|max:15',
                'license_number' => 'required|string|max:50|unique:owners,license_number',
            ]);

            $owner = Owner::create($validated);

            return response()->json([
                'success' => true,
                'owner_id' => $owner->own_id,
                'message' => 'Owner registered successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register owner: ' . $e->getMessage(),
            ], 500);
        }
    }
}