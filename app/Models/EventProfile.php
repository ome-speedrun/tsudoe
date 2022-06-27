<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventProfile extends UuidModel
{
    public $primaryKey = 'event_id';

    protected $fillable = [
        'event_id',
        'name',
        'description',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
