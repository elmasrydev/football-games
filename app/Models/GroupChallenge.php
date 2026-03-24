<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupChallenge extends Model
{
    protected $fillable = [
        'game_id',
        'title',
        'image',
        'players_count',
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

    public function players(): HasMany
    {
        return $this->hasMany(GroupChallengePlayer::class)->orderBy('sort_order');
    }

    public function hints(): HasMany
    {
        return $this->hasMany(GroupChallengeHint::class)->orderBy('sort_order');
    }
}
