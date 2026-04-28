<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
