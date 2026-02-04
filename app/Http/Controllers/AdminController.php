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
        
        // Extract document type from purpose (format: "Document Type - Purpose")
        $purposeParts = explode(' - ', $request->purpose, 2);
        $documentType = $purposeParts[0] ?? 'Document Request';
        $actualPurpose = $purposeParts[1] ?? $request->purpose;
        
        return response()->json([
            'resident_name' => $request->resident->name,
            'document_type' => $documentType,
            'purpose' => $actualPurpose,
            'status' => $request->status,
            'requested_at' => $request->created_at->format('M d, Y h:i A')
        ]);
    }

    public function approveRequest($id)
    {
        $request = DocumentRequest::findOrFail($id);
        $request->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Document request approved successfully!');
    }

    public function rejectRequest($id)
    {
        $request = DocumentRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Document request rejected.');
    }

    public function viewDocument($id)
    {
        $request = DocumentRequest::with('resident')->findOrFail($id);
        
        // Extract document type from purpose
        $purposeParts = explode(' - ', $request->purpose, 2);
        $documentType = $purposeParts[0] ?? 'Document Request';
        $actualPurpose = $purposeParts[1] ?? $request->purpose;
        
        // Determine which document view to show based on document type
        $viewMap = [
            'Certificate of Indigency' => 'admin.documents.indigency',
            'Agricultural Certification' => 'admin.documents.agricultural',
            'Barangay Certification' => 'admin.documents.barangay',
            'Business Certification' => 'admin.documents.business',
            'Certificate of Good Moral' => 'admin.documents.good-moral',
        ];
        
        $view = $viewMap[$documentType] ?? 'admin.documents.generic';
        
        return view($view, compact('request', 'documentType', 'actualPurpose'));
    }

    
}
