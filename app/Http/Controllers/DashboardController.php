<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        $totalEvents = $events->count();
        $totalCapacity = $events->sum('total_tickets');
        $remainingTickets = $events->sum('remaining_tickets');
        $ticketsSold = $totalCapacity - $remainingTickets;

        $highestSellingEvent = $events
            ->sortByDesc(fn ($event) => $event->total_tickets - $event->remaining_tickets)
            ->first();

        $lowestInventoryEvent = $events
            ->where('remaining_tickets', '>', 0)
            ->sortBy('remaining_tickets')
            ->first();

        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'totalEvents' => $totalEvents,
                'ticketsSold' => $ticketsSold,
                'remainingTickets' => $remainingTickets,
                'totalCapacity' => $totalCapacity,
                'sellThrough' => $totalCapacity > 0
                    ? round(($ticketsSold / $totalCapacity) * 100, 2)
                    : 0,
                'soldOutEvents' => $events->where('remaining_tickets', 0)->count(),
                'highestSellingEvent' => $highestSellingEvent ? [
                    'title' => $highestSellingEvent->title,
                    'sold' => $highestSellingEvent->total_tickets - $highestSellingEvent->remaining_tickets,
                ] : null,
                'lowestInventoryEvent' => $lowestInventoryEvent ? [
                    'title' => $lowestInventoryEvent->title,
                    'remaining' => $lowestInventoryEvent->remaining_tickets,
                ] : null,
            ],
        ]);
    }
}