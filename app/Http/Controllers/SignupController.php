<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
  
    public function store(Request $request)
    {
        // Validate input with custom message for duplicate email
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ], [
            'email.unique' => 'This email is already registered.',
        ]);

        try {
            // Create user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
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

        // Attempt to find user by email or username
        $user = User::where('email', $request->username)
                    ->orWhere('name', $request->username)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login successful, set session or use Auth
            Auth::login($user);

            // Redirect to dashboard
            return redirect()->route('home.admin')->with('success', 'Login successful!');
        } else {
            // Invalid credentials
            return back()->with('error', 'Invalid username or password.');
        }
    }

}
