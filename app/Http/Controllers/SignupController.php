<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
  
    public function store(Request $request)
    {
        // Validate input with custom message for duplicate email
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'email' => 'required|email|unique:residents,email|unique:users,email',
            'password' => 'required|string|min:6',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string|max:20',
            'purok' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'cash_assistance_programs' => 'required|string|max:255',
        ], [
            'email.unique' => 'This email is already registered.',
        ]);

        try {
            // Calculate age from birthdate
            $age = \Carbon\Carbon::parse($request->birthdate)->age;
            
            // Combine names
            $fullName = trim($request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name . ' ' . ($request->suffix ?? ''));
            
            // Create user with resident role
            $user = User::create([
                'name' => $fullName,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'resident',
                'age' => $age,
                'civil_status' => $request->civil_status,
                'purok' => $request->purok,
                'barangay' => 'Bagacay',
                'city' => 'Dumaguete City',
                'full_address' => $request->full_address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_indigent' => $request->cash_assistance_programs,
                'purpose' => 'Resident Registration',
                'date_issued' => now()->format('Y-m-d'),
            ]);

            // Auto-login the new resident
            Auth::login($user);

            // Redirect to user interface
            return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');

        } catch (\Exception $e) {
            // Generic error
            return back()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }


    public function LoginUser(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to find user by email
        $user = User::where('email', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login successful
            Auth::login($user);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('home.admin')->with('success', 'Admin login successful!');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'Login successful!');
            }
        } else {
            // Invalid credentials
            return back()->with('error', 'Invalid username or password.');
        }
    }

}
