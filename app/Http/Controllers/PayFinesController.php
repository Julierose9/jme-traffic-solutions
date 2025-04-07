<?php

namespace App\Http\Controllers;

use App\Models\ViolationRecord; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayFinesController extends Controller
{
    public function index()
    {
        $fines = ViolationRecord::with('violation')
            ->where('status', 'unpaid') 
            ->get();

        return view('guest.payfines', compact('fines')); 
    }

    public function payFine($id)
    {
        $fine = ViolationRecord::findOrFail($id);

        if ($fine->status === 'paid') {
            return redirect()->route('pay.fines')->with('error', 'This fine has already been paid.');
        }

        $fine->update(['status' => 'paid']);
        Log::info("Fine with ID {$id} has been paid.");

        return redirect()->route('pay.fines')->with('success', 'Fine paid successfully.');
    }
}