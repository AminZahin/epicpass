# 🎫 EpicPass — Real-Time Event & Ticketing Platform

[![Laravel 13](https://shields.io)](https://laravel.com)
[![PHP 8.4](https://shields.io)](https://php.net)
[![Inertia.js](https://shields.io)](https://inertiajs.com)
[![Tests Passing](https://shields.io)]()

An enterprise-grade, high-concurrency event management and ticketing SaaS designed to handle high-traffic "ticket rushes." This project showcases modern **Laravel 13** architectural patterns, real-time WebSocket broadcasting, and secure transaction handling.

---

## 🚀 Core Architectural Highlights (Why This Dynamic?)

Instead of standard CRUD operations, this project implements production-level engineering solutions to common industry problems:

*   **⚡ Concurrency Control (The Ticket Rush Solution)**: Utilizes database-level pessimistic locking (`sharedLock` and `lockForUpdate`) wrapped in atomized transactions to prevent double-booking or ticket overselling at the exact same millisecond.
*   **📡 Real-Time Broadcasting**: Employs **Laravel Reverb** with the new database driver to broadcast live ticket inventory updates to frontend dashboards without page refreshes.
*   **⚙️ Asynchronous Processing**: Leverages background database queues for PDF generation, ticket QR-code compilation, and automated transactional email dispatching.
*   **💳 Webhook Integration**: Fully integrates with Stripe via Laravel Cashier, utilizing secure webhook signatures to provision tickets only upon verified ledger updates.

---

## 🛠️ The Tech Stack

*   **Backend Framework:** Laravel 13 (utilizing modern PHP 8.4 attributes)
*   **Frontend System:** Inertia.js (Vue 3 / React) paired with Tailwind CSS
*   **Database Engine:** PostgreSQL (Optimized indices for relational searching)
*   **Real-time Engine:** Laravel Reverb (Native WebSockets server)
*   **Testing Suite:** Pest PHP (Feature and Unit test isolation)
*   **Code Quality Suite:** Laravel Pint (Strict code styling enforcement)

---

## 🗄️ Database Strategy & Concurrency Guard

To prevent race conditions when thousands of users click "Buy Ticket" simultaneously, the system locks database rows strictly during calculation checks:

```php
use App\Models\Event;
use Illuminate\Support\Facades\DB;

DB::transaction(function () use (eventId, userId) {
    // Lock the event row for update to prevent simultaneous reading/writing
    event = Event::where('id', eventId)
        ->lockForUpdate()
        ->firstOrFail();

    if (\$event->remaining_tickets <= 0) {
        throw new \Exception('Tickets are officially sold out.');
    }

    // Decrement inventory and issue ticket atomically
    \$event->decrement('remaining_tickets');
    \(event->tickets()->create(['user_id' =>\)userId]);
});
```

---

## 🧪 Testing Coverage (100% Confidence)

The codebase features rigorous automated testing using **Pest PHP** to guarantee reliability under severe workloads.

```bash
# Run tests with parallel execution optimized for speed
php artisan test --parallel
```

### Example Feature Test: Ticket Rush Scenario
```php
it('prevents overselling when tickets hit absolute zero capacity', function () {
    \$event = Event::factory()->create(['remaining_tickets' => 1]);
    
    // Simulate first purchase
    response1 = this->actingAs(this->user1)->post("/events/event->id}/purchase");
    \$response1->assertStatus(200);

    // Simulate simultaneous click on empty inventory
    response2 = this->actingAs(this->user2)->post("/events/event->id}/purchase");
    \$response2->assertStatus(422); // Unprocessable Entity due to exhaustion
    
    expect(\$event->fresh()->remaining_tickets)->toBe(0);
});
```

---

## 📈 Key Engineering Takeaways (What I Learned)

1.  **Race Conditions are Real:** I learned how to isolate critical business loops within database transactions to ensure data consistency under immense horizontal stress.
2.  **State Management over API Boilerplate:** Using Inertia.js allowed me to drop complex state-synchronization patterns usually required between standalone client apps and separate API repositories.
3.  **Clean Code Patterns:** Utilized Laravel 13's PHP class attribute syntax to declare routing parameters, validation models, and continuous integration constraints natively inside the core controller modules.

---

## 💻 Getting Started Locally

```bash
# 1. Clone the repository
git clone https://github.com

# 2. Install dependencies
composer install && npm install

# 3. Configure local environment variables
cp .env.example .env

# 4. Spin up the application containers via Laravel Sail
./vendor/bin/sail up -d

# 5. Execute migrations and seed database parameters
./vendor/bin/sail artisan migrate --seed
```
