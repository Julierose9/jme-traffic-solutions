<?php

namespace App\Http\Controllers;

use App\Models\VehicleRegistrationRequest;
use App\Models\RegisteredVehicle;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VehicleRegistrationRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect('/')->with('error', 'Unauthorized access');
        })->except(['store']);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'vehicle_type' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'plate_number' => 'required|string|max:255|unique:registered_vehicles,plate_number|unique:vehicle_registration_requests,plate_number',
                'color' => 'required|string|max:255',
                'notes' => 'nullable|string'
            ]);

            // Add user_id and default status
            $validatedData['user_id'] = auth()->id();
            $validatedData['status'] = 'pending';

            // Create the request
            $registrationRequest = VehicleRegistrationRequest::create($validatedData);

            // Log the creation for debugging
            \Log::info('Vehicle registration request created:', ['request' => $registrationRequest]);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle registration request submitted successfully!',
                'request' => $registrationRequest
            ]);
        } catch (ValidationException $e) {
            \Log::error('Validation error in vehicle registration:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in vehicle registration:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $requests = VehicleRegistrationRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.vehicle-requests', compact('requests'));
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $request = VehicleRegistrationRequest::with('user')->findOrFail($id);
            
            if ($request->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This request has already been ' . $request->status
                ]);
            }

            $owner = Owner::where('user_id', $request->user_id)->first();
            
            if (!$owner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Owner information not found'
                ]);
            }

            // Create new registered vehicle
            $vehicle = new RegisteredVehicle();
            $vehicle->plate_number = $request->plate_number;
            $vehicle->vehicle_type = $request->vehicle_type;
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->color = $request->color;
            $vehicle->own_id = $owner->own_id;
            $vehicle->registration_date = now();
            $vehicle->save();

            // Update request status
            $request->status = 'approved';
            $request->save();

            // Create notification in database
            DB::table('notifications')->insert([
                'user_id' => $request->user_id,
                'title' => 'Vehicle Registration Approved',
                'message' => "Your vehicle registration request for {$request->brand} {$request->model} has been approved.",
                'type' => 'success',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vehicle registration request approved successfully',
                'vehicle' => $vehicle
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in VehicleRegistrationRequestController@approve: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while approving the request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject($id)
    {
        try {
            DB::beginTransaction();

            $request = VehicleRegistrationRequest::findOrFail($id);

            if ($request->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This request has already been ' . $request->status
                ], 400);
            }

            // Update request status
            $request->status = 'rejected';
            $request->save();

            // Create notification in database
            DB::table('notifications')->insert([
                'user_id' => $request->user_id,
                'title' => 'Vehicle Registration Rejected',
                'message' => "Your vehicle registration request for {$request->brand} {$request->model} has been rejected.",
                'type' => 'error',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Request rejected successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to reject vehicle registration request:', [
                'request_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject request: ' . $e->getMessage()
            ], 500);
        }
    }
} 