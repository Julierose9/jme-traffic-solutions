<?php

namespace App\Http\Controllers;

use App\Models\RegisteredVehicle;
use App\Models\Blacklist;
use App\Models\ViolationRecord;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $registeredVehiclesCount = RegisteredVehicle::count();
        $blacklistedVehiclesCount = Blacklist::where('status', 'Active')->count();
        $pendingPaymentsCount = ViolationRecord::where('status', 'unpaid')->count();
        $totalViolationsCount = ViolationRecord::count();

        return view('admin.dashboard', compact(
            'registeredVehiclesCount',
            'blacklistedVehiclesCount',
            'pendingPaymentsCount',
            'totalViolationsCount'
        ));
    }
} 