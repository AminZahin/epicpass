<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventManagementController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/events/Index', [
            'events' => Event::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/events/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'total_tickets' => ['required', 'integer', 'min:1'],
            'event_date' => ['required', 'date'],
        ]);

        $validated['remaining_tickets'] = $validated['total_tickets'];

        Event::create($validated);

        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event)
    {
        return Inertia::render('admin/events/Edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'total_tickets' => ['required', 'integer', 'min:1'],
            'event_date' => ['required', 'date'],
        ]);

        $soldTickets = $event->total_tickets - $event->remaining_tickets;
        $validated['remaining_tickets'] = max($validated['total_tickets'] - $soldTickets, 0);

        $event->update($validated);

        return redirect()->route('admin.events.index');
    }

    public function destroy(Event $event)
    {
        if ($event->tickets()->exists()) {
            return back()->withErrors([
                'event' => 'Cannot delete an event that already has purchased tickets.',
            ]);
        }

        $event->delete();

        return redirect()->route('admin.events.index');
    }
}