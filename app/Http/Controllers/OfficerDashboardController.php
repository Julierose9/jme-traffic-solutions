<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord;
use App\Models\Report;
use App\Models\Officer;
use Illuminate\Support\Facades\Auth;

class OfficerDashboardController extends Controller
{
    public function index()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            
            // Get or create the officer record
            $officer = Officer::firstOrCreate(
                ['email' => $user->email],
                [
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'rank' => 'Officer',
                    'contact_num' => '0000000000'
                ]
            );

            // Get all violations issued by this officer
            $violations = ViolationRecord::where('officer_id', $officer->officer_id)
                ->with(['violation', 'vehicle'])
                ->orderBy('violation_date', 'desc')
                ->get();

            // Get all reports created by this officer
            $reports = Report::where('officer_id', $officer->officer_id)
                ->with(['violation', 'vehicle'])
                ->orderBy('report_date', 'desc')
                ->get();

            // Calculate total records (violations + reports)
            $totalRecords = $violations->count() + $reports->count();

            // Calculate pending records
            $pendingRecords = $violations->where('status', 'unpaid')->count() + 
                            $reports->where('status', 'pending')->count();

            // Calculate completed records
            $completedRecords = $violations->where('status', 'paid')->count() + 
                              $reports->where('status', 'paid')->count();

            return view('officer.dashboard', compact(
                'violations',
                'reports',
                'totalRecords',
                'pendingRecords',
                'completedRecords'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in officer dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading dashboard data');
        }
    }
} 