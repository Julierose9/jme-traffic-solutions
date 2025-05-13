<?php
namespace App\Http\Controllers;

use App\Models\RegisteredVehicle; // Import the RegisteredVehicle model
use App\Models\Owner; // Import the Owner model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    // Method to show the register vehicle page
    public function showRegisterVehicle()
    {
        // Fetch all registered vehicles from the database
        $registeredVehicles = RegisteredVehicle::all(); 

        // Fetch all owners from the database
        $owners = Owner::all(); 

        // Pass the registered vehicles and owners to the view
        return view('admin.registerVehicle', compact('registeredVehicles', 'owners'));
    }

    // Method to show guest dashboard with registered vehicles
    public function showGuestDashboard()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();
        
        // Fetch registered vehicles for the authenticated user
        $registeredVehicles = RegisteredVehicle::whereHas('owner', function($query) use ($userId) {
            $query->where('own_id', $userId);
        })->get();

        return view('guest.dashboard', compact('registeredVehicles'));
    }

    // Method to handle the vehicle registration form submission
    public function registerVehicle(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'own_id' => 'required|exists:owners,own_id',
                'plate_number' => 'required|string|max:255|unique:registered_vehicles,plate_number',
                'vehicle_type' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'registration_date' => 'required|date',
            ]);

            // Create a new registered vehicle
            $vehicle = RegisteredVehicle::create($validatedData);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vehicle registered successfully!',
                    'vehicle' => $vehicle
                ]);
            }

            // Redirect back to the register vehicle page with a success message
            return redirect()->route('register.vehicle')->with('success', 'Vehicle registered successfully!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to register vehicle: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to register vehicle: ' . $e->getMessage());
        }
    }

    // Method to handle vehicle updates
    public function update(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
                'own_id' => 'required|exists:owners,own_id',
                'plate_number' => 'required|string|max:255|unique:registered_vehicles,plate_number,' . $request->reg_vehicle_id . ',reg_vehicle_id',
                'vehicle_type' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'registration_date' => 'required|date',
            ]);

            // Find the vehicle by reg_vehicle_id
            $vehicle = RegisteredVehicle::where('reg_vehicle_id', $request->reg_vehicle_id)->firstOrFail();

            // Update the vehicle with validated data
            $vehicle->update([
                'own_id' => $validatedData['own_id'],
                'plate_number' => $validatedData['plate_number'],
                'vehicle_type' => $validatedData['vehicle_type'],
                'brand' => $validatedData['brand'],
                'model' => $validatedData['model'],
                'color' => $validatedData['color'],
                'registration_date' => $validatedData['registration_date'],
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vehicle updated successfully!',
                    'vehicle' => $vehicle
                ]);
            }

            return redirect()->route('register.vehicle')->with('success', 'Vehicle updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update vehicle: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to update vehicle: ' . $e->getMessage())->withInput();
        }
    }

    // Method to handle vehicle deletion
    public function destroy(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            ]);

            // Find the vehicle by reg_vehicle_id
            $vehicle = RegisteredVehicle::where('reg_vehicle_id', $request->reg_vehicle_id)->firstOrFail();

            // Delete the vehicle
            $vehicle->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vehicle deleted successfully!'
                ]);
            }

            return redirect()->route('register.vehicle')->with('success', 'Vehicle deleted successfully!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete vehicle: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete vehicle: ' . $e->getMessage())->withInput();
        }
    }
}