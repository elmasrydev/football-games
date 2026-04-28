<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    protected $fillable = [
        'game_id',
        'genre_id',
        'difficulty',
        'stimulus_type',
        'stimulus_data',
        'answer',
        'answers',
        'answer_type',
        'autocomplete_type',
        'is_active',
    ];

    protected $casts = [
        'stimulus_data' => 'json',
        'answers' => 'json',
        'is_active' => 'boolean',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function hints(): HasMany
    {
        return $this->hasMany(ChallengeHint::class);
    }
}
