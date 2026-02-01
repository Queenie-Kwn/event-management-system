<?php

namespace App\Http\Controllers;

use App\Models\Resident;
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

    
}
