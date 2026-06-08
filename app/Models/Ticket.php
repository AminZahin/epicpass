<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = ['event_id', 'user_id', 'ticket_code'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
