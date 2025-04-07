<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\RegisteredVehicle; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViolationRecordController extends Controller
{
    public function index()
    {
        $violationRecords = DB::table('violation_records as vr')
            ->join('violations as v', 'vr.violation_id', '=', 'v.violation_id')
            ->join('officers as o', 'vr.officer_id', '=', 'o.officer_id')
            ->select('vr.record_id', 'v.violation_code', 'v.description', 'v.penalty_amount', 
                     'o.lname as officer_last_name', 'o.fname as officer_first_name', 
                     'vr.violation_date', 'vr.status')
            ->get();
    
        return view('admin.violationRecords', compact('violationRecords'));
    }

    public function showViolationHistory()
{
    $ownerId = Auth::id();

    $violationRecords = DB::table('violation_records as vr')
        ->join('violations as v', 'vr.violation_id', '=', 'v.violation_id')
        ->join('reports as r', 'vr.record_id', '=', 'r.violation_id')
        ->join('registered_vehicles as rv', 'r.reg_vehicle_id', '=', 'rv.reg_vehicle_id') 
        ->where('rv.own_id', $ownerId) 
        ->select('vr.record_id', 'v.violation_code', 'rv.plate_number', 'vr.violation_date', 'vr.status')
        ->get();

    return view('guest.violationhistory', compact('violationRecords'));
}
}