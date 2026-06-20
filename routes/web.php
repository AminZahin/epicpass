<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::inertia('dashboard', 'Dashboard')
        ->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');;

    Route ::get('/events', [EventController::class, 'index'])
        ->name('events.index');

    Route::get('/events/{event}', [EventController::class, 'show'])
        ->name('events.show');

    Route::post('/events/{event}/purchase', [TicketController::class, 'purchase'])
        ->name('events.purchase');
});

require __DIR__.'/settings.php';