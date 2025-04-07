<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\RegisteredVehicle; 
use App\Models\Owner;
use Illuminate\Http\Request;

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
        if ($request->has('plate_number')) {
            $request->validate([
                'plate_number' => 'required|string',
            ]);
    
            $blacklistStatus = Blacklist::with('registeredVehicle')
                ->whereHas('registeredVehicle', function ($query) use ($request) {
                    $query->where('plate_number', $request->plate_number);
                })
                ->first();
        } else {
            $blacklistStatus = null; 
        }
    
        return view('guest.blackliststatus', compact('blacklistStatus'));
    }
}