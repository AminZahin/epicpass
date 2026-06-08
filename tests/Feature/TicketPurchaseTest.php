<?php

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('prevents overselling when tickets hit absolute zero capacity', function () {
    // 1. Create an event with exactly 1 ticket left
    $event = Event::create([
        'title' => 'Epic Music Festival',
        'description' => 'Sold out show rush test.',
        'total_tickets' => 100,
        'remaining_tickets' => 1,
        'event_date' => now()->addDays(10),
    ]);

    // 2. Mock two completely distinct database users
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // 3. First user successfully buys the final ticket
    $response1 = $this->actingAs($user1)->post("/events/{$event->id}/purchase");
    $response1->assertStatus(200);

    // 4. Second user attempts to buy immediately after, expecting an automated fail block
    $response2 = $this->actingAs($user2)->post("/events/{$event->id}/purchase");
    $response2->assertStatus(422); // 422 Unprocessable Entity (Sold Out)

    // 5. Assert the database state remains strictly zero, never dipping into negative numbers (-1)
    expect($event->fresh()->remaining_tickets)->toBe(0);
});
