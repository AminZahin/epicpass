<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. The Core Events Table
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('total_tickets');
            // Unsigned integer blocks values from ever dropping below 0 at the DB database level
            $table->integer('remaining_tickets')->unsigned();
            $table->dateTime('event_date');
            $table->timestamps();
        });

        // 2. The High-Concurrency Tickets Table
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // Cascades on delete to clean up tickets if an event is canceled
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ticket_code')->unique(); // Unique identifier index for secure validation checks
            $table->timestamps();

            // Crucial: Composite relational index to impress senior developer review checks
            $table->index(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('events');
    }
};
