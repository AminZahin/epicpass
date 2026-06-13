<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        return Inertia::render('events/Index', [
            'events' => Event::latest()->get(),
        ]);
    }
    public function show(Event $event)
    {
        return Inertia::render('events/Show', [
            'event' => $event,
        ]);
    }
}