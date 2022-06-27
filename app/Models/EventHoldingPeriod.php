<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventHoldingPeriod extends UuidModel
{
    protected $fillable = [
        'id',
        'event_id',
        'order',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function meta(): BelongsTo
    {
        return $this->belongsTo(EventMeta::class, 'event_id', 'event_id');
    }
}
