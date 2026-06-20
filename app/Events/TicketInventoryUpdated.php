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
        $totalEvents = Event::count();
        $totalCapacity = Event::sum('total_tickets');
        $remainingTickets = Event::sum('remaining_tickets');
        $ticketsSold = $totalCapacity - $remainingTickets;

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
                'sellThrough' => $totalCapacity > 0
                    ? round(($ticketsSold / $totalCapacity) * 100, 2)
                    : 0,
            ],
        ];
    }
}