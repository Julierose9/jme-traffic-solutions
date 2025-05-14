Route::get('/owner/{ownerId}/vehicles', function ($ownerId) {
    $vehicles = \App\Models\RegisteredVehicle::where('own_id', $ownerId)->get();
    return response()->json($vehicles);
}); 