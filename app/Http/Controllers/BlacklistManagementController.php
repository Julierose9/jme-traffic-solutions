<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\RegisteredVehicle; 
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlacklistManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $blacklistedVehicles = Blacklist::with(['registeredVehicle', 'owner'])->get();
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
        try {
        $request->validate([
            'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id', 
            'own_id' => 'required|exists:owners,own_id',
            'reason' => 'required|string',
                'blacklist_type' => 'required|in:Violation-Based,License Suspension',
        ]);

            DB::beginTransaction();

            $blacklist = Blacklist::create([
            'reg_vehicle_id' => $request->reg_vehicle_id,
            'own_id' => $request->own_id,
            'reason' => $request->reason,
            'blacklist_type' => $request->blacklist_type,
                'date_added' => Carbon::now()->toDateString(),
                'status' => 'Active',
                'appeal_status' => 'Pending'
        ]);

            DB::commit();

            return redirect()->route('blacklist.management')
                ->with('success', 'Vehicle has been blacklisted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to blacklist vehicle: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $blacklistEntry = Blacklist::with(['registeredVehicle', 'owner'])->findOrFail($id);
        $vehicles = RegisteredVehicle::all();
        $owners = Owner::all();

        return view('admin.blacklistEdit', compact('blacklistEntry', 'vehicles', 'owners'));
    }

    public function update(Request $request, $id)
    {
        try {
        $request->validate([
                'reg_vehicle_id' => 'required|exists:registered_vehicles,reg_vehicle_id',
                'own_id' => 'required|exists:owners,own_id',
            'reason' => 'required|string',
                'blacklist_type' => 'required|in:Violation-Based,License Suspension',
                'status' => 'required|in:Active,Lifted',
                'appeal_status' => 'required|in:Pending,Approved,Rejected'
        ]);

            DB::beginTransaction();

            $blacklist = Blacklist::findOrFail($id);
        
            $blacklist->update([
                'reg_vehicle_id' => $request->reg_vehicle_id,
                'own_id' => $request->own_id,
            'reason' => $request->reason,
            'blacklist_type' => $request->blacklist_type,
                'status' => $request->status,
                'appeal_status' => $request->appeal_status,
                'lifted_date' => $request->status === 'Lifted' ? Carbon::now() : null
            ]);

            DB::commit();

            return redirect()->route('blacklist.management')
                ->with('success', 'Blacklist entry updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to update blacklist entry: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $blacklist = Blacklist::findOrFail($id);
            $blacklist->delete();

            DB::commit();

            return redirect()->route('blacklist.management')
                ->with('success', 'Blacklist entry removed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to remove blacklist entry: ' . $e->getMessage());
        }
    }

    public function checkStatus()
    {
        $userId = auth()->id();

        // Get blacklist entries for the authenticated user's vehicles
        $blacklistStatus = Blacklist::with(['vehicle', 'report'])
            ->whereHas('vehicle.owner', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'Active')
            ->get()
            ->map(function($blacklist) {
                return (object)[
                    'vehicle' => $blacklist->vehicle->plate_number . ' - ' . 
                                $blacklist->vehicle->brand . ' ' . 
                                $blacklist->vehicle->model,
                    'reason' => $blacklist->reason,
                    'type' => $blacklist->blacklist_type,
                    'date_added' => \Carbon\Carbon::parse($blacklist->date_added)->format('M d, Y'),
                    'description' => $blacklist->description,
                    'report' => $blacklist->report ? [
                        'details' => $blacklist->report->report_details,
                        'date' => \Carbon\Carbon::parse($blacklist->report->report_date)->format('M d, Y'),
                        'location' => $blacklist->report->location
                    ] : null
                ];
            });

        return view('guest.blackliststatus', compact('blacklistStatus'));
    }

    public function getDetails($id)
    {
        try {
            $blacklist = Blacklist::with([
                'registeredVehicle',
                'owner',
                'report.violation'
            ])->findOrFail($id);

            $data = [
                'violation' => null,
                'vehicle' => [
                    'plate_number' => $blacklist->registeredVehicle->plate_number,
                    'vehicle_type' => $blacklist->registeredVehicle->vehicle_type,
                    'brand' => $blacklist->registeredVehicle->brand,
                    'model' => $blacklist->registeredVehicle->model,
                    'color' => $blacklist->registeredVehicle->color,
                    'registration_date' => $blacklist->registeredVehicle->registration_date
                ],
                'owner' => [
                    'lname' => $blacklist->owner->lname,
                    'fname' => $blacklist->owner->fname,
                    'mname' => $blacklist->owner->mname,
                    'address' => $blacklist->owner->address,
                    'contact_number' => $blacklist->owner->contact_number
                ]
            ];

            // Only add violation data if report and violation exist
            if ($blacklist->report && $blacklist->report->violation) {
                $data['violation'] = [
                    'violation_code' => $blacklist->report->violation->violation_code,
                    'description' => $blacklist->report->violation->description,
                    'penalty_amount' => (float)$blacklist->report->violation->penalty_amount,
                    'status' => $blacklist->report->status
                ];
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch details: ' . $e->getMessage()], 500);
        }
    }
}