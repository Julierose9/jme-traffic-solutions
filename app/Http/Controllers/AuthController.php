<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin')->with('success', 'Logged in successfully!');
            } elseif ($user->role === 'officer') {
                return redirect()->route('dashboard.officer')->with('success', 'Logged in successfully!');
            } else {
                return redirect()->route('dashboard.guest')->with('success', 'Logged in successfully!');
            }
        }
    
        return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    public function register(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'role' => 'required|in:admin,officer,guest',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|confirmed|min:6',
            'contact_num' => 'required_if:role,officer|string|max:255',
            'rank' => 'required_if:role,officer|string|max:255',
        ]);

        try {
            \DB::beginTransaction();

            // Create the user
            $user = new User;
            $user->role = $validated['role'];
            $user->fname = $validated['fname'];
            $user->mname = $validated['mname'];
            $user->lname = $validated['lname'];
            $user->email = $validated['email'];
            $user->username = $validated['username'];
            $user->password = Hash::make($validated['password']);
            $user->save();

            // If the role is officer, create an officer record
            if ($validated['role'] === 'officer') {
                \App\Models\Officer::create([
                    'fname' => $validated['fname'],
                    'mname' => $validated['mname'],
                    'lname' => $validated['lname'],
                    'email' => $validated['email'],
                    'rank' => $validated['rank'],
                    'contact_num' => $validated['contact_num'],
                ]);
            }

            \DB::commit();
            return redirect()->route('welcome')->with('success', 'Registration successful! Please log in.');
        } catch (Exception $e) {
            \DB::rollBack();
            // Log the error for debugging
            \Log::error('User registration failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'An error occurred during registration. Please try again.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome')->with('success', 'Logged out successfully!');
    }
}