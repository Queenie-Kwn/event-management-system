<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function EventDisplay()
    {
        // Check if events table is empty, create default row
        if (Event::count() == 0) {
            Event::create([
                'title' => 'Sample Barangay Event',
                'description' => 'This is a sample event.',
                'event_date' => now()->toDateString(),
                'start_time' => now()->format('H:i:s'),
                'end_time' => now()->addHours(2)->format('H:i:s'),
                'location' => 'Barangay Hall'
            ]);
        }

        // Get events with pagination (5 per page)
        $events = Event::orderBy('event_date', 'desc')->paginate(5);

        return view('portals.events', compact('events'));
    }
}
