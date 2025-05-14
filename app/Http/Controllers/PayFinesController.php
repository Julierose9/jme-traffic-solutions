<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\RegisteredVehicle;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PayFinesController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.pay.fines');
        } else {
            $query = ViolationRecord::with(['violation', 'registeredVehicle'])
                ->join('registered_vehicles', 'violation_records.reg_vehicle_id', '=', 'registered_vehicles.reg_vehicle_id')
                ->join('owners', 'registered_vehicles.own_id', '=', 'owners.own_id')
                ->where('owners.user_id', Auth::id())
                ->where('violation_records.status', 'unpaid');

            // If a specific vehicle is requested, filter by it
            if ($request->has('vehicle')) {
                $query->where('violation_records.reg_vehicle_id', $request->vehicle);
            }

            $fines = $query->select('violation_records.*')->get();
            return view('guest.payfines', compact('fines'));
        }
    }

    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('pay.fines')->with('error', 'Unauthorized access.');
        }

        $fines = ViolationRecord::with(['violation', 'registeredVehicle.owner'])
            ->where('status', 'unpaid')
            ->orderBy('violation_date', 'desc')
            ->get();

        return view('admin.payfines', compact('fines'));
    }

    public function payFine($id)
    {
        $fine = ViolationRecord::findOrFail($id);

        if (!Auth::user()->isAdmin()) {
            $isAuthorized = ViolationRecord::where('violation_records.record_id', $id)
                ->join('registered_vehicles', 'violation_records.reg_vehicle_id', '=', 'registered_vehicles.reg_vehicle_id')
                ->join('owners', 'registered_vehicles.own_id', '=', 'owners.own_id')
                ->where('owners.own_id', Auth::id())
                ->exists();
            if (!$isAuthorized) {
                return redirect()->route('pay.fines')->with('error', 'You are not authorized to pay this fine.');
            }
        }

        if ($fine->status === 'paid') {
            $redirectRoute = Auth::user()->isAdmin() ? 'admin.pay.fines' : 'pay.fines';
            return redirect()->route($redirectRoute)->with('error', 'This fine has already been paid.');
        }

        $fine->update(['status' => 'paid']);
        Log::info("Fine with ID {$id} has been paid by user ID " . Auth::id());

        $redirectRoute = Auth::user()->isAdmin() ? 'admin.pay.fines' : 'pay.fines';
        return redirect()->route($redirectRoute)->with('success', 'Fine paid successfully.');
    }

    public function guestIndexRecords()
    {
        $records = ViolationRecord::with('violation')
            ->join('registered_vehicles', 'violation_records.reg_vehicle_id', '=', 'registered_vehicles.reg_vehicle_id')
            ->join('owners', 'registered_vehicles.own_id', '=', 'owners.own_id')
            ->where('owners.own_id', Auth::id())
            ->select('violation_records.*')
            ->get();
        return view('guest.violation_history', compact('records'));
    }
}