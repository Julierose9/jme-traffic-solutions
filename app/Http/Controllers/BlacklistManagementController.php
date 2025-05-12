<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\RegisteredVehicle; 
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlacklistManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $blacklistedVehicles = Blacklist::with('registeredVehicle', 'owner')->get(); 
        $vehicles = RegisteredVehicle::all(); 
        $owners = Owner::all(); 
        
        return view('admin.blacklistManagement', compact('blacklistedVehicles', 'vehicles', 'owners'));
    }

    public function create()
    {
        $vehicles = RegisteredVehicle::all(); 
        $owners = Owner::all(); 
        
        return view('admin.blacklistCreate', compact('vehicles', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id', 
            'own_id' => 'required|exists:owners,own_id',
            'reason' => 'required|string',
            'blacklist_type' => 'required|string',
        ]);

        Blacklist::create([
            'reg_vehicle_id' => $request->reg_vehicle_id,
            'own_id' => $request->own_id,
            'reason' => $request->reason,
            'blacklist_type' => $request->blacklist_type,
            'date_added' => now(),
            'status' => 'active', 
            'appeal_status' => 'pending', 
        ]);

        return redirect()->route('blacklist.management')->with('success', 'Blacklist entry added successfully.');
    }

    public function edit($id)
    {
        $blacklistEntry = Blacklist::findOrFail($id);
        $vehicles = RegisteredVehicle::all();
        $owners = Owner::all();

        return view('admin.blacklistEdit', compact('blacklistEntry', 'vehicles', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'blacklist_type' => 'required|string',
        ]);

        $blacklistEntry = Blacklist::findOrFail($id);
        
        $blacklistEntry->update([
            'reason' => $request->reason,
            'blacklist_type' => $request->blacklist_type,
        ]);

        return redirect()->route('blacklist.management')->with('success', 'Blacklist entry updated successfully.');
    }

    public function destroy($id)
    {
        $blacklistEntry = Blacklist::findOrFail($id);
        
        $blacklistEntry->delete();

        return redirect()->route('blacklist.management')->with('success', 'Blacklist entry deleted successfully.');
    }
    public function checkStatus(Request $request)
    {
        $userId = Auth::id(); // Get the ID of the authenticated user
    
        // Start the query to fetch blacklist records
        $query = Blacklist::with(['registeredVehicle', 'owner'])
            ->join('registered_vehicles', 'blacklists.reg_vehicle_id', '=', 'registered_vehicles.reg_vehicle_id')
            ->join('owners', 'blacklists.own_id', '=', 'owners.own_id')
            ->where('owners.own_id', $userId) // Filter by own_id matching the authenticated user's ID
            ->select('blacklists.*');
    
        // If a plate number is provided, add it to the query
        if ($request->has('plate_number') && !empty($request->plate_number)) {
            $query->where('registered_vehicles.plate_number', $request->plate_number);
        }
    
        // Fetch the results
        $blacklistStatus = $query->get();
    
        return view('guest.blackliststatus', compact('blacklistStatus'));
    }
}