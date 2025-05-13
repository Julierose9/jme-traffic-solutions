<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportRequest;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    public function index()
    {
        return view('guest.support');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            SupportRequest::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);
            return redirect()->route('support')->with('success', 'Your support request has been submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Support request submission failed: ' . $e->getMessage());
            return redirect()->route('support')->with('error', 'Failed to submit your support request. Please try again.');
        }
    }
}