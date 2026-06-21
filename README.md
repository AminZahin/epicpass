# 🎫 EpicPass

**EpicPass** is a real-time event ticketing platform built with **Laravel 13**, **Vue 3**, **Inertia.js**, **MySQL**, **Laravel Reverb**, and **Docker**.

The project focuses on solving a real backend problem: preventing ticket overselling during high-concurrency purchase scenarios while keeping ticket inventory and analytics updated in real time.

---

## 🚀 Core Features

### 🎫 Event Ticketing

* Event listing page
* Event detail page
* Ticket purchasing workflow
* Admin event management
* Create, edit, and delete events

### 🔒 Concurrency-Safe Purchasing

* MySQL transaction-based purchase flow
* Pessimistic locking with `lockForUpdate()`
* Overselling prevention when multiple users buy tickets at the same time
* Database-level protection against negative ticket inventory

### ⚡ Real-Time Inventory Updates

* Laravel Reverb WebSocket integration
* Real-time ticket counter updates
* Multi-tab inventory synchronization without refresh

### 📊 Live Analytics Dashboard

* Total Events
* Total Capacity
* Tickets Sold
* Remaining Tickets
* Sell Through Rate
* Sold Out Events
* Highest Selling Event
* Lowest Inventory Event
* Real-time analytics updates after each ticket purchase

### 🎨 Custom UI & Branding

* Custom EpicPass landing page
* Custom EpicPass logo
* Redesigned authentication pages
* Clean sidebar navigation
* Dark analytics dashboard interface

---

## 🧠 Engineering Highlights

EpicPass demonstrates practical backend and full-stack engineering concepts:

* Database transactions
* Pessimistic row locking
* Race condition prevention
* WebSocket broadcasting
* Real-time client synchronization
* Feature testing with Pest
* Dockerized local development
* Laravel + Inertia.js application architecture

---

## 🏗️ System Architecture

```text
Browser
  ↓
Vue 3 + Inertia.js
  ↓
Laravel Routes
  ↓
Controllers
  ↓
MySQL Transaction
  ↓
lockForUpdate()
  ↓
Ticket Created Safely
  ↓
Broadcast Event
  ↓
Laravel Reverb
  ↓
Real-Time UI Updates
```

---

## ⚡ Ticket Purchase Flow

```text
User clicks "Buy Ticket"
        ↓
TicketController receives request
        ↓
Event row is locked using lockForUpdate()
        ↓
System checks remaining_tickets
        ↓
Ticket is created inside a DB transaction
        ↓
Inventory is decremented safely
        ↓
TicketInventoryUpdated event is broadcast
        ↓
Event page and analytics dashboard update live
```

---

## 🛠️ Tech Stack

| Area                    | Technology                              |
| ----------------------- | --------------------------------------- |
| Backend                 | Laravel 13, PHP 8.4                     |
| Frontend                | Vue 3, Inertia.js                       |
| Database                | MySQL                                   |
| Real-Time               | Laravel Reverb, Laravel Echo, Pusher JS |
| Testing                 | Pest                                    |
| Development Environment | Docker, Laravel Sail                    |
| Styling                 | Tailwind CSS                            |
| Version Control         | Git, GitHub                             |

---

## 📁 Key Project Structure

```text
app/
├── Events/
│   └── TicketInventoryUpdated.php
├── Http/
│   └── Controllers/
│       ├── Admin/
│       │   └── EventManagementController.php
│       ├── DashboardController.php
│       ├── EventController.php
│       └── TicketController.php
├── Models/
│   ├── Event.php
│   └── Ticket.php

resources/js/pages/
├── Welcome.vue
├── admin/
│   ├── Dashboard.vue
│   └── events/
│       ├── Index.vue
│       ├── Create.vue
│       └── Edit.vue
├── auth/
└── events/
    ├── Index.vue
    └── Show.vue

tests/Feature/
├── AdminEventManagementTest.php
└── TicketPurchaseTest.php
```

---

## 🧪 Testing

Run all tests:

```bash
./vendor/bin/sail artisan test
```

Run ticket purchase test only:

```bash
./vendor/bin/sail artisan test --filter=TicketPurchaseTest
```

Run admin event management tests:

```bash
./vendor/bin/sail artisan test --filter=AdminEventManagementTest
```

---

## 💻 Local Development Setup

Clone the repository:

```bash
git clone git@github.com:AminZahin/epicpass.git
cd epicpass
```

Install dependencies:

```bash
composer install
npm install
```

Copy environment file:

```bash
cp .env.example .env
```

Start Docker containers:

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

Start Reverb WebSocket server:

```bash
./vendor/bin/sail artisan reverb:start
```

Open the application:

```text
http://localhost
```

---

## 🔴 Real-Time Demo Flow

To test the real-time feature locally:

1. Open `/events/1` in two browser tabs.
2. Click **Buy Ticket** in one tab.
3. The other tab updates its remaining ticket count without refresh.
4. Open `/admin/dashboard` in another tab.
5. Buy another ticket.
6. Analytics metrics update live.

---

## 📦 Releases

### v0.6.0 — Admin Event Management

* Added admin event management page
* Added create event form
* Added edit event form
* Added delete event action
* Added delete protection for events with purchased tickets
* Enhanced analytics dashboard with deeper event metrics
* Added admin event management test coverage

### v0.5.0 — Real-Time Ticketing Platform

* Added custom EpicPass branding
* Added custom landing page
* Redesigned authentication pages
* Added live analytics dashboard updates
* Improved navigation and user experience

### v0.4.0 — Admin Analytics Dashboard

* Added analytics dashboard
* Added ticket sales overview
* Added remaining inventory metrics

### v0.3.0 — Real-Time Inventory Updates

* Added Laravel Reverb broadcasting
* Added WebSocket-powered inventory updates
* Synced ticket counters across browser tabs

### v0.2.0 — Event Listing Page

* Added event listing page
* Added event detail navigation

### v0.1.0 — Concurrency-Safe Ticket Purchasing

* Added event and ticket schema
* Added ticket purchase flow
* Added transaction-safe inventory decrement
* Added overselling prevention with `lockForUpdate()`

---

## 🗺️ Roadmap

Possible future improvements:

* QR code ticket generation
* Email ticket confirmation
* Payment gateway integration
* Admin role authorization
* Event status workflow
* Queue-based ticket processing
* Screenshot and demo GIF in README
* Deployment notes

---

## 👨‍💻 Author

Built by **Amin Zahin** as a backend/full-stack portfolio project focused on:

* Laravel development
* Database concurrency control
* Real-time systems
* WebSocket broadcasting
* Scalable application design
