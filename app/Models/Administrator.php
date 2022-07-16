<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AutenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Administrator extends UuidModel implements Authenticatable
{
    use HasFactory;
    use AutenticatableTrait;

    protected $fillable = [
        'id',
    ];

    public function discord(): HasOne
    {
        return $this->hasOne(AdminDiscord::class);
    }

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }
}
