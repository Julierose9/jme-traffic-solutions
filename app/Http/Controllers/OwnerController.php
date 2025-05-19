<?php
namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function registerOwner(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'address' => 'required|string|max:255',
                'contact_num' => 'required|string|max:20',
                'license_number' => 'required|string|max:50|unique:owners,license_number',
            ]);

            // Create the owner record
            $owner = Owner::create($validatedData);

            if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                    'message' => 'Owner registered successfully!',
                    'owner_id' => $owner->own_id
                ]);
            }

            return redirect()->back()->with('success', 'Owner registered successfully!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                    'message' => 'Failed to register owner: ' . $e->getMessage()
            ], 500);
        }

            return redirect()->back()->with('error', 'Failed to register owner: ' . $e->getMessage())->withInput();
        }
    }

    public function getGuestWithoutOwner()
    {
        // Get all guest users who don't have an owner record yet
        $guestUsers = User::where('role', 'guest')
            ->whereDoesntHave('owner')
            ->get();

        return response()->json([
            'success' => true,
            'guests' => $guestUsers
        ]);
    }

    public function getOwnerDetails($ownerId)
    {
        try {
            $owner = Owner::with(['user', 'registeredVehicles'])
                ->findOrFail($ownerId);

            return response()->json([
                'success' => true,
                'owner' => $owner
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch owner details: ' . $e->getMessage()
            ], 500);
        }
    }
}