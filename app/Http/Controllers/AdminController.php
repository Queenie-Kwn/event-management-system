<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display residents list
     */
    public function residentsList(Request $request)
    {
        $query = Resident::query();

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $residents = $query->orderBy('full_name')->get();

        return view('portals.residents-list', compact('residents'));
    }

    public function indigency()
    {
        $residents = Resident::orderBy('full_name')->get();

        return view('portals.dashboard', compact('residents'));
    }

    public function documentRequests()
    {
        $requests = DocumentRequest::with('resident')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portals.document-requests', compact('requests'));
    }

    public function showDocumentRequest($id)
    {
        $request = DocumentRequest::with('resident')->findOrFail($id);
        
        return response()->json([
            'resident_name' => $request->resident->full_name,
            'document_type' => $request->document_type,
            'purpose' => $request->purpose,
            'status' => $request->status,
            'requested_at' => $request->created_at->format('M d, Y h:i A')
        ]);
    }

    
}
