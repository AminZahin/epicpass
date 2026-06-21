<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketInventoryUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Event $event
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('events.' . $this->event->id),
            new Channel('analytics.dashboard'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ticket.inventory.updated';
    }

    public function broadcastWith(): array
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

        return [
            'event' => [
                'id' => $this->event->id,
                'total_tickets' => $this->event->total_tickets,
                'remaining_tickets' => $this->event->remaining_tickets,
                'sold_tickets' => $this->event->total_tickets - $this->event->remaining_tickets,
            ],
            'analytics' => [
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
        ];
    }
}