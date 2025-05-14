<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\RegisteredVehicle;
use App\Models\Owner;

// Add this route without auth middleware since we're using session auth
Route::get('/owner/{ownerId}/vehicles', function ($ownerId) {
    try {
        // First check if owner exists
        $owner = Owner::findOrFail($ownerId);

        $vehicles = RegisteredVehicle::where('own_id', $ownerId)
            ->get()
            ->map(function ($vehicle) {
                return [
                    'reg_vehicle_id' => $vehicle->reg_vehicle_id,
                    'plate_number' => $vehicle->plate_number,
                    'brand' => $vehicle->brand,
                    'model' => $vehicle->model,
                    'vehicle_type' => $vehicle->vehicle_type,
                    'color' => $vehicle->color
                ];
            });

        if ($vehicles->isEmpty()) {
            return response()->json([
                'message' => 'No vehicles found for this owner'
            ], 200);
        }

        return response()->json($vehicles);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Owner not found'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to fetch vehicles: ' . $e->getMessage()
        ], 500);
    }
}); 