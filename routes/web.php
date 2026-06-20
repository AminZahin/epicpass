<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('/dashboard', '/events')->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])
        ->name('events.index');

    Route::get('/events/{event}', [EventController::class, 'show'])
        ->name('events.show');

    Route::post('/events/{event}/purchase', [TicketController::class, 'purchase'])
        ->name('events.purchase');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

require __DIR__.'/settings.php';