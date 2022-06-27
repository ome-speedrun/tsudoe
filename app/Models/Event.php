<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends UuidModel
{
    protected $fillable = [
        'id',
        'slug',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(EventProfile::class);
    }

    public function meta(): HasOne
    {
        return $this->hasOne(EventMeta::class);
    }
}
