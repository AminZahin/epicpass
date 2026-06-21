<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventManagementController;
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

    Route::get('/admin/events', [EventManagementController::class, 'index'])
    ->name('admin.events.index');

    Route::get('/admin/events/create', [EventManagementController::class, 'create'])
        ->name('admin.events.create');

    Route::post('/admin/events', [EventManagementController::class, 'store'])
        ->name('admin.events.store');

    Route::get('/admin/events/{event}/edit', [EventManagementController::class, 'edit'])
        ->name('admin.events.edit');

    Route::put('/admin/events/{event}', [EventManagementController::class, 'update'])
        ->name('admin.events.update');

    Route::delete('/admin/events/{event}', [EventManagementController::class, 'destroy'])
        ->name('admin.events.destroy');
});

require __DIR__.'/settings.php';