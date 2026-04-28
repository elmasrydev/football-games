<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{


    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function challenges(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'challenges')->distinct();
    }
}
