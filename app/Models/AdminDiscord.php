<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminDiscord extends UuidModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'discord_id',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
