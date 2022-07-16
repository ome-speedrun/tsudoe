<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Application extends UuidModel
{
    use HasApiTokens;

    protected $fillable = [
        'id',
        'name',
    ];

    public function administrators(): BelongsToMany
    {
        return $this->belongsToMany(Administrator::class);
    }
}
