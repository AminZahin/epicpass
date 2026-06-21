# 🎫 EpicPass

A real-time event ticketing platform built with Laravel 13, Vue 3, Inertia.js, MySQL, and Laravel Reverb.

EpicPass demonstrates how high-concurrency ticket purchases can be handled safely using database transactions, pessimistic locking, and real-time inventory synchronization.

---

## 🚀 Features

### 🎫 Event Management

* Event listing page
* Event detail page
* Ticket purchasing workflow

### ⚡ Real-Time Updates

* Laravel Reverb WebSocket integration
* Live ticket inventory synchronization
* Multi-tab updates without refresh

### 📊 Real-Time Analytics

* Live analytics dashboard
* Tickets sold tracking
* Remaining inventory tracking
* Sell-through rate calculation

### 🔒 Concurrency Protection

* MySQL transactions
* Pessimistic locking (`lockForUpdate()`)
* Overselling prevention

### 🎨 User Experience

* Custom EpicPass branding
* Responsive landing page
* Redesigned authentication pages
* Modern Vue 3 interface

---

## 🧠 Engineering Focus

EpicPass was built to showcase backend engineering concepts commonly used in high-traffic systems:

* Transaction-safe inventory management
* Database row locking
* Real-time event broadcasting
* WebSocket communication
* Feature testing
* Modern Laravel architecture

---

## 🏗️ Architecture

```text
Browser
    │
    ▼
Vue 3 + Inertia.js
    │
    ▼
Laravel Controllers
    │
    ▼
Database Transactions
    │
    ▼
lockForUpdate()
    │
    ▼
MySQL
    │
    ▼
Laravel Reverb
    │
    ▼
Real-Time Client Updates
```

---

## ⚡ Real-Time Purchase Flow

```text
User purchases ticket
        │
        ▼
TicketController
        │
        ▼
DB::transaction()
        │
        ▼
lockForUpdate()
        │
        ▼
Ticket created safely
        │
        ▼
Broadcast Event
        │
        ▼
Laravel Reverb
        │
        ▼
Events Page Updates
Analytics Dashboard Updates
```

---

## 🧪 Testing

Run all tests:

```bash
./vendor/bin/sail artisan test
```

Run the ticket purchase concurrency test:

```bash
./vendor/bin/sail artisan test --filter=TicketPurchaseTest
```

---

## 🛠️ Technology Stack

| Area            | Technology           |
| --------------- | -------------------- |
| Backend         | Laravel 13, PHP 8.4  |
| Frontend        | Vue 3, Inertia.js    |
| Database        | MySQL                |
| Real-Time       | Laravel Reverb       |
| Testing         | Pest                 |
| Development     | Docker, Laravel Sail |
| Version Control | Git, GitHub          |

---

## 💻 Local Setup

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

Configure environment:

```bash
cp .env.example .env
```

Start containers:

```bash
./vendor/bin/sail up -d
```

Generate application key:

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

Open:

```text
http://localhost
```

---

## 📦 Releases

### v0.5.0 — Real-Time Ticketing Platform

Implemented:

* Event listing page
* Event detail page
* Ticket purchasing workflow
* Real-time inventory updates
* Real-time analytics dashboard
* Laravel Reverb integration
* Overselling prevention
* Custom EpicPass branding
* Landing page redesign
* Authentication page redesign

---

## 🗺️ Roadmap

### v0.6.0

* Event CRUD management
* Admin event creation
* Event editing
* Event deletion

### Future Ideas

* QR code tickets
* Email confirmations
* Payment gateway integration
* Queue-based ticket processing
* Multi-event analytics

---

## 👨‍💻 Author

Built by Amin Zahin as a backend engineering portfolio project focused on:

* Laravel development
* Database concurrency control
* Real-time systems
* Scalable application design
