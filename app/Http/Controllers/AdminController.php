<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\AdminLog;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    use LogsAdminActivity;
    /**
     * Display admin dashboard with system overview
     */
    public function dashboard()
    {
        // Get current date for filtering
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();
        
        // Total counts
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalRequests = DocumentRequest::count();
        $totalEvents = Event::count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Request statistics
        $pendingRequests = DocumentRequest::where('status', 'pending')->count();
        $approvedRequests = DocumentRequest::where('status', 'approved')->count();
        $rejectedRequests = DocumentRequest::where('status', 'rejected')->count();
        
        // Monthly statistics
        $monthlyRequests = DocumentRequest::where('created_at', '>=', $thisMonth)->count();
        $monthlyUsers = User::where('role', '!=', 'admin')
                           ->where('created_at', '>=', $thisMonth)
                           ->count();
        
        // Document type breakdown
        $documentTypes = DocumentRequest::selectRaw('SUBSTRING_INDEX(purpose, " - ", 1) as doc_type, COUNT(*) as count')
                                      ->groupBy('doc_type')
                                      ->orderBy('count', 'desc')
                                      ->get();
        
        // Recent activities - handle both User and Resident models
        $recentRequests = DocumentRequest::with('resident')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
        
        $recentUsers = User::where('role', '!=', 'admin')
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();
        
        // Purok distribution
        $purokDistribution = User::where('role', '!=', 'admin')
                                ->whereNotNull('purok')
                                ->selectRaw('purok, COUNT(*) as count')
                                ->groupBy('purok')
                                ->orderBy('count', 'desc')
                                ->get();
        
        // Status distribution for chart
        $statusData = [
            'pending' => $pendingRequests,
            'approved' => $approvedRequests,
            'rejected' => $rejectedRequests
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalRequests', 'totalEvents', 'totalAdmins',
            'pendingRequests', 'approvedRequests', 'rejectedRequests',
            'monthlyRequests', 'monthlyUsers', 'documentTypes',
            'recentRequests', 'recentUsers', 'purokDistribution', 'statusData'
        ));
    }

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
        
        $this->logActivity('APPROVE_REQUEST', "Approved document request ID: {$id} for user: {$request->resident->name}");
        
        return redirect()->back()->with('success', 'Document request approved successfully!');
    }

    public function rejectRequest($id)
    {
        $request = DocumentRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        
        $this->logActivity('REJECT_REQUEST', "Rejected document request ID: {$id} for user: {$request->resident->name}");
        
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

    public function adminLogs()
    {
        $logs = AdminLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.logs', compact('logs'));
    }

    public function createAdminForm()
    {
        return view('admin.create-admin');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin',
            'civil_status' => 'Single',
            'purok' => 'Admin Office',
            'barangay' => 'Bagacay',
            'city' => 'Dumaguete City',
            'is_indigent' => 'N/A',
            'purpose' => 'Admin Account',
            'date_issued' => now()->format('Y-m-d'),
        ]);

        $this->logActivity('CREATE_ADMIN', "Created new admin account: {$admin->name} ({$admin->email})");

        return redirect()->route('admin.create-admin')->with('success', 'Admin account created successfully!');
    }

    public function residentsWithGeoTag()
    {
        $residents = User::where('role', '!=', 'admin')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
            
        return view('admin.residents-map', compact('residents'));
    }

    
}
