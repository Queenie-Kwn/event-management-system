<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
  
    public function store(Request $request)
    {
        // Validate input with custom message for duplicate email
        $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|unique:residents,email',
            'password' => 'required|string|min:6',
            'age' => 'required|integer|min:1',
            'civil_status' => 'required|string|max:20',
            'purok' => 'required|string|max:100',
            'indigent_status' => 'required|string|max:20',
        ], [
            'email.unique' => 'This email is already registered.',
        ]);

        try {
            // Create resident
            Resident::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'age' => $request->age,
                'civil_status' => $request->civil_status,
                'purok' => $request->purok,
                'barangay' => $request->barangay ?? 'Bagacay',
                'city' => $request->city ?? 'Dumaguete City',
                'indigent_status' => $request->indigent_status,
            ]);

            // Success message using browser alert
            return back()->with('success', 'Signup successful!');

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

        // Attempt to find resident by email
        $resident = Resident::where('email', $request->username)->first();

        if ($resident && Hash::check($request->password, $resident->password)) {
            // Login successful, set session or use Auth
            Auth::guard('resident')->login($resident);

            // Redirect to dashboard
            return redirect()->route('home.admin')->with('success', 'Login successful!');
        } else {
            // Invalid credentials
            return back()->with('error', 'Invalid username or password.');
        }
    }

}
