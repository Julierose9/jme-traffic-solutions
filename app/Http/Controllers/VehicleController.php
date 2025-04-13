<?php
namespace App\Http\Controllers;

use App\Models\RegisteredVehicle; // Import the RegisteredVehicle model
use App\Models\Owner; // Import the Owner model
use Illuminate\Http\Request;

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

    // Method to handle the vehicle registration form submission
    public function registerVehicle(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'own_id' => 'required|exists:owners,own_id',
            'plate_number' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'registration_date' => 'required|date',
        ]);

        // Create a new registered vehicle
        RegisteredVehicle::create($validatedData);

        // Redirect back to the register vehicle page with a success message
        return redirect()->route('register.vehicle')->with('success', 'Vehicle registered successfully!');
    }

    // Method to handle vehicle updates
    public function update(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
            'own_id' => 'required|exists:owners,own_id',
            'plate_number' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'registration_date' => 'required|date',
        ]);

        // Find the vehicle by ID
        $vehicle = RegisteredVehicle::findOrFail($request->reg_vehicle_id);

        // Update the vehicle with validated data
        $vehicle->update($validatedData);

        // Redirect back to the register vehicle page with a success message
        return redirect()->route('register.vehicle')->with('success', 'Vehicle updated successfully!');
    }

    // Method to handle vehicle deletion
    public function destroy(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
        ]);

        // Find the vehicle by ID
        $vehicle = RegisteredVehicle::findOrFail($request->reg_vehicle_id);

        // Delete the vehicle
        $vehicle->delete();

        // Redirect back to the register vehicle page with a success message
        return redirect()->route('register.vehicle')->with('success', 'Vehicle deleted successfully!');
    }
}