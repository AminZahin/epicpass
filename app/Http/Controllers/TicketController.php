<?php

namespace App\Http\Controllers;

use App\Events\TicketInventoryUpdated;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class TicketController extends Controller
{
    public function purchase(Request $request, $id)
    {
        try {
            $result = DB::transaction(function () use ($request, $id) {
                $event = Event::where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($event->remaining_tickets <= 0) {
                    return response()->json([
                        'message' => 'Tickets are completely sold out!',
                    ], 422);
                }

                $event->decrement('remaining_tickets');
                $event->refresh();

                $ticket = $event->tickets()->create([
                    'user_id' => $request->user()->id,
                    'ticket_code' => 'EPIC-' . strtoupper(Str::random(10)),
                ]);

                return [
                    'event' => $event,
                    'ticket' => $ticket,
                ];
            });

            broadcast(new TicketInventoryUpdated($result['event']))->toOthers();

            return response()->json([
                'message' => 'Ticket purchased successfully!',
                'ticket' => $result['ticket'],
            ], 200);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}