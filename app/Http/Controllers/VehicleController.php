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
            'own_id' => 'required|string',
            'plate_number' => 'required|string',
            'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'color' => 'required|string',
            'registration_date' => 'required|date',
        ]);

        // Create a new registered vehicle
        RegisteredVehicle::create($validatedData);

        // Redirect back to the register vehicle page with a success message
        return redirect()->route('register.vehicle')->with('success', 'Vehicle registered successfully!');
    }
}