<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function purchase(Request $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $event = Event::where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($event->remaining_tickets <= 0) {
                    return response()->json([
                        'message' => 'Tickets are completely sold out!'
                    ], 422);
                }

                $event->decrement('remaining_tickets');

                $ticket = $event->tickets()->create([
                    'user_id' => $request->user()->id,
                    'ticket_code' => 'EPIC-' . strtoupper(Str::random(10)),
                ]);

                return response()->json([
                    'message' => 'Ticket purchased successfully!',
                    'ticket' => $ticket
                ], 200);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaction failure.'], 500);
        }
    }
}