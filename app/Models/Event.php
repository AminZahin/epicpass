<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    // Allow mass filling of these fields
    protected $fillable = [
        'title', 
        'description', 
        'total_tickets', 
        'remaining_tickets', 
        'event_date'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
