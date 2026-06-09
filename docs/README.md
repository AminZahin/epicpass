# 🎫 EpicPass

**EpicPass** is a high-concurrency event ticketing platform built with **Laravel 13, Inertia.js, Vue 3, MySQL, Docker, and Pest**.

The main goal of this project is to demonstrate how ticket inventory can be protected during high-traffic purchase scenarios using **database transactions** and **pessimistic locking**.

---

## 🚀 Current Features

* Event ticket inventory display
* Ticket purchase flow
* MySQL-based transaction safety
* Pessimistic locking with `lockForUpdate()`
* Overselling prevention
* Pest feature test for ticket rush scenario
* Inertia.js + Vue 3 event dashboard
* Dockerized local development with Laravel Sail

---

## 🧠 Why This Project Matters

A normal ticket purchase system can fail when multiple users buy the final ticket at the same time.

EpicPass solves this by wrapping the purchase process inside a database transaction and locking the event row before checking and decrementing the remaining ticket count.

```php
DB::transaction(function () use ($request, $id) {
    $event = Event::where('id', $id)
        ->lockForUpdate()
        ->firstOrFail();

    if ($event->remaining_tickets <= 0) {
        return response()->json([
            'message' => 'Tickets are completely sold out!'
        ], 422);
    }

    $event->decrement('remaining_tickets');

    return $event->tickets()->create([
        'user_id' => $request->user()->id,
        'ticket_code' => 'EPIC-' . strtoupper(Str::random(10)),
    ]);
});
```

---

## 🏗️ Architecture Overview

```text
Browser (Vue 3 + Inertia.js)
        |
        v
Laravel Route
        |
        v
TicketController
        |
        v
DB::transaction()
        |
        v
lockForUpdate()
        |
        v
MySQL events table
        |
        v
Ticket issued safely
```

---

## 🛠️ Tech Stack

| Area                    | Technology                      |
| ----------------------- | ------------------------------- |
| Backend                 | Laravel 13, PHP 8.4             |
| Frontend                | Inertia.js, Vue 3, Tailwind CSS |
| Database                | MySQL                           |
| Development Environment | Laravel Sail, Docker, WSL2      |
| Testing                 | Pest PHP                        |
| Version Control         | Git, GitHub                     |

---

## 🧪 Testing

EpicPass includes a Pest feature test that verifies the system prevents overselling when only one ticket remains.

```bash
./vendor/bin/sail artisan test
```

Specific ticket purchase test:

```bash
./vendor/bin/sail artisan test --filter=TicketPurchaseTest
```

---

## 💻 Local Setup

Clone the repository:

```bash
git clone git@github.com:AminZahin/epicpass.git
cd epicpass
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Copy environment file:

```bash
cp .env.example .env
```

Start Laravel Sail:

```bash
./vendor/bin/sail up -d
```

Generate app key:

```bash
./vendor/bin/sail artisan key:generate
```

Run migrations:

```bash
./vendor/bin/sail artisan migrate
```

Start Vite:

```bash
./vendor/bin/sail npm run dev
```

Open the application:

```text
http://localhost
```

---

## 📌 Current Release

### v0.1.0 — Concurrency-safe Ticket Purchasing

Implemented:

* Event and ticket database schema
* Ticket purchase controller
* Transaction-safe purchase flow
* Pessimistic database locking
* Overselling prevention test
* Basic event dashboard UI

---

## 🗺️ Roadmap

### v0.2.0 — Event Listing Page

* `/events` page
* List all events
* Link to individual event purchase page

### v0.3.0 — Real-Time Inventory Updates

* Laravel Reverb integration
* Broadcast ticket inventory updates
* Live counter update without refresh

### v0.4.0 — Admin Analytics Dashboard

* Total tickets sold
* Remaining inventory
* Event performance overview

### v0.5.0 — Portfolio Polish

* Screenshots
* Demo GIF
* Architecture diagram
* Deployment notes

---

## 👨‍💻 Author

Built by **Amin Zahin** as a high-scale Laravel portfolio project focused on backend engineering, database safety, and real-world system design.
