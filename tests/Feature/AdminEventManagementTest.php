<?php

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows authenticated users to create an event', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/events', [
        'title' => 'Laravel Live 2026',
        'description' => 'A Laravel community event.',
        'total_tickets' => 250,
        'event_date' => now()->addMonth()->format('Y-m-d H:i:s'),
    ]);

    $response->assertRedirect(route('admin.events.index'));

    $this->assertDatabaseHas('events', [
        'title' => 'Laravel Live 2026',
        'total_tickets' => 250,
        'remaining_tickets' => 250,
    ]);
});

it('allows authenticated users to update an event', function () {
    $user = User::factory()->create();

    $event = Event::create([
        'title' => 'Old Event',
        'description' => 'Old description.',
        'total_tickets' => 100,
        'remaining_tickets' => 100,
        'event_date' => now()->addWeek(),
    ]);

    $response = $this->actingAs($user)->put("/admin/events/{$event->id}", [
        'title' => 'Updated Event',
        'description' => 'Updated description.',
        'total_tickets' => 150,
        'event_date' => now()->addMonth()->format('Y-m-d H:i:s'),
    ]);

    $response->assertRedirect(route('admin.events.index'));

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'title' => 'Updated Event',
        'total_tickets' => 150,
        'remaining_tickets' => 150,
    ]);
});

it('allows authenticated users to delete an event without tickets', function () {
    $user = User::factory()->create();

    $event = Event::create([
        'title' => 'Delete Me',
        'description' => 'Temporary event.',
        'total_tickets' => 50,
        'remaining_tickets' => 50,
        'event_date' => now()->addWeek(),
    ]);

    $response = $this->actingAs($user)->delete("/admin/events/{$event->id}");

    $response->assertRedirect(route('admin.events.index'));

    $this->assertDatabaseMissing('events', [
        'id' => $event->id,
    ]);
});

it('prevents deleting an event with purchased tickets', function () {
    $user = User::factory()->create();

    $event = Event::create([
        'title' => 'Protected Event',
        'description' => 'Has tickets.',
        'total_tickets' => 100,
        'remaining_tickets' => 99,
        'event_date' => now()->addWeek(),
    ]);

    Ticket::create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'ticket_code' => 'EPIC-TEST123',
    ]);

    $response = $this->actingAs($user)->delete("/admin/events/{$event->id}");

    $response->assertSessionHasErrors('event');

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
    ]);
});