<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SilhouetteChallenge extends Model
{
    protected $fillable = [
        'game_id',
        'image_path',
        'reveal_image_path',
        'player_name',
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
        return $this->hasMany(SilhouetteHint::class)->orderBy('sort_order');
    }
}
