<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentRequest;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        // Get recent document requests for the user
        $recentRequests = DocumentRequest::where('resident_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        return view('home.user', compact('user', 'recentRequests'));
    }

    public function myRequests()
    {
        $user = Auth::user();
        $requests = DocumentRequest::where('resident_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.requests', compact('requests'));
    }

    public function requestDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'purpose' => 'required|string|max:500',
        ]);

        DocumentRequest::create([
            'resident_id' => Auth::user()->user_id,
            'purpose' => $request->document_type . ' - ' . $request->purpose,
            'request_date' => now()->format('Y-m-d'),
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Document request submitted successfully!');
    }

    public function requestIndigency()
    {
        return view('user.documents.indigency');
    }

    public function requestAgricultural()
    {
        return view('user.documents.agricultural');
    }

    public function requestBarangay()
    {
        return view('user.documents.barangay');
    }

    public function requestBusiness()
    {
        return view('user.documents.business');
    }

    public function requestGoodMoral()
    {
        return view('user.documents.good-moral');
    }
}