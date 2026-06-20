<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $remainingTickets = Event::sum('remaining_tickets');
        $totalCapacity = Event::sum('total_tickets');
        $ticketsSold = $totalCapacity - $remainingTickets;

        $sellThrough = $totalCapacity > 0
            ? round(($ticketsSold / $totalCapacity) * 100, 2)
            : 0;

        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'totalEvents' => $totalEvents,
                'ticketsSold' => $ticketsSold,
                'remainingTickets' => $remainingTickets,
                'sellThrough' => $sellThrough,
            ],
        ]);
    }
}