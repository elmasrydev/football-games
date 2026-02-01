<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KitChallenge extends Model
{
    protected $fillable = [
        'game_id',
        'image_path',
        'full_image_path',
        'team_name',
        'kit_year',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function hints(): HasMany
    {
        return $this->hasMany(KitHint::class)->orderBy('sort_order');
    }
}
