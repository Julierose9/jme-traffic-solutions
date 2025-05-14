<?php
namespace App\Http\Controllers;

use App\Models\RegisteredVehicle; // Import the RegisteredVehicle model
use App\Models\Owner; // Import the Owner model
use App\Models\User;
use App\Models\VehicleRegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Only allow admin access to these methods
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)->only(['showRegisterVehicle', 'registerVehicle', 'update', 'destroy']);
    }

    // Method to show the register vehicle page
    public function showRegisterVehicle()
    {
        // Fetch all registered vehicles from the database
        $registeredVehicles = RegisteredVehicle::with(['owner.user'])->get();

        // Fetch guest users who don't have an owner record yet
        $users = User::where('role', 'guest')
            ->whereDoesntHave('owner')
            ->orderBy('lname')
            ->orderBy('fname')
            ->orderBy('mname')
            ->get();

        // Fetch existing owners who are linked to guest users
        $owners = Owner::whereHas('user', function($query) {
            $query->where('role', 'guest');
        })
        ->with('user')
        ->orderBy('lname')
        ->orderBy('fname')
        ->orderBy('mname')
        ->get();

        // For debugging
        \Log::info('Guest users count: ' . $users->count());
        \Log::info('Guest users data: ' . $users->toJson());
        \Log::info('Owners count: ' . $owners->count());
        \Log::info('Owners data: ' . $owners->toJson());

        $requests = VehicleRegistrationRequest::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.registerVehicle', compact('registeredVehicles', 'users', 'owners', 'requests'));
    }

    // Method to show guest dashboard with registered vehicles
    public function showGuestDashboard()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();
        
        // Fetch registered vehicles for the authenticated user through owner relationship
        // Include blacklists and violation records for status checks
        $registeredVehicles = RegisteredVehicle::with(['owner', 'blacklists', 'violationRecords'])
            ->whereHas('owner', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();

        return view('guest.dashboard', compact('registeredVehicles'));
    }

    // Method to handle the vehicle registration form submission
    public function registerVehicle(Request $request)
    {
        try {
            // First validate the owner data
            $ownerData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'address' => 'required|string|max:255',
                'contact_num' => 'required|string|max:20',
                'license_number' => 'required|string|max:50|unique:owners,license_number',
            ]);

            // Get the user data to copy name fields
            $user = User::findOrFail($ownerData['user_id']);
            
            // Create owner data with name fields from user
            $ownerData = array_merge($ownerData, [
                'fname' => $user->fname,
                'mname' => $user->mname,
                'lname' => $user->lname,
            ]);

            // Create the owner record
            $owner = Owner::create($ownerData);

            // Then validate and create the vehicle record
            $vehicleData = $request->validate([
                'plate_number' => 'required|string|max:255|unique:registered_vehicles,plate_number',
            'vehicle_type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'registration_date' => 'required|date',
        ]);

            // Add the owner_id to the vehicle data
            $vehicleData['own_id'] = $owner->own_id;

            // Create the vehicle record
            $vehicle = RegisteredVehicle::create($vehicleData);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vehicle registered successfully!',
                    'vehicle' => $vehicle
                ]);
            }

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
            // Ensure user is admin
            if (!Auth::user()->isAdmin()) {
                throw new \Exception('Only administrators can update vehicle details.');
            }

            // Start database transaction
            DB::beginTransaction();

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
                // Owner details
                'address' => 'required|string|max:255',
                'contact_num' => 'required|string|max:20',
                'license_number' => 'required|string|max:50|unique:owners,license_number,' . $request->own_id . ',own_id',
        ]);

            // Find the owner and update their details
            $owner = Owner::findOrFail($validatedData['own_id']);
            $owner->update([
                'address' => $validatedData['address'],
                'contact_num' => $validatedData['contact_num'],
                'license_number' => $validatedData['license_number'],
            ]);

            // Find and update the vehicle
            $vehicle = RegisteredVehicle::findOrFail($validatedData['reg_vehicle_id']);
            $vehicle->update([
                'plate_number' => $validatedData['plate_number'],
                'vehicle_type' => $validatedData['vehicle_type'],
                'brand' => $validatedData['brand'],
                'model' => $validatedData['model'],
                'color' => $validatedData['color'],
                'registration_date' => $validatedData['registration_date'],
            ]);

            // Commit the transaction
            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vehicle and owner details updated successfully!',
                    'vehicle' => $vehicle,
                    'owner' => $owner
                ]);
            }

            return redirect()->route('register.vehicle')->with('success', 'Vehicle and owner details updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update details: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update details: ' . $e->getMessage());
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

    public function index()
    {
        $vehicles = RegisteredVehicle::all();
        $requests = VehicleRegistrationRequest::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('admin.registerVehicle', compact('vehicles', 'requests'));
    }

    public function getVehicleDetails($id)
    {
        try {
            $vehicle = RegisteredVehicle::findOrFail($id);
            $owner = Owner::with('user')->findOrFail($vehicle->own_id);

            return response()->json([
                'success' => true,
                'vehicle' => $vehicle,
                'owner' => $owner
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vehicle details: ' . $e->getMessage()
            ], 500);
        }
    }
}