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
        'language',
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

    // ── Stimulus Data Proxies ──
    public function getImagePathAttribute() { return $this->stimulus_data['image_path'] ?? null; }
    public function getRevealImagePathAttribute() { return $this->stimulus_data['reveal_image_path'] ?? null; }
    public function getYoutubeUrlAttribute() { return $this->stimulus_data['youtube_url'] ?? null; }
    public function getQuestionAttribute() { return $this->stimulus_data['question'] ?? ($this->stimulus_data['clue'] ?? null); }
    public function getScrambledWordAttribute() { return $this->stimulus_data['scrambled_word'] ?? null; }
    public function getPartAAttribute() { return $this->stimulus_data['part_a'] ?? null; }
    public function getPartBAttribute() { return $this->stimulus_data['part_b'] ?? null; }
    public function getClubAAttribute() { return $this->stimulus_data['club_a'] ?? null; }
    public function getClubBAttribute() { return $this->stimulus_data['club_b'] ?? null; }

    // ── Level Progress Attributes ──
    public function getCurrentLevelAttribute(): int
    {
        return static::where('game_id', $this->game_id)
            ->where('genre_id', $this->genre_id)
            ->where('language', $this->language)
            ->where('id', '<=', $this->id)
            ->count();
    }

    public function getTotalLevelsAttribute(): int
    {
        return static::where('game_id', $this->game_id)
            ->where('genre_id', $this->genre_id)
            ->where('language', $this->language)
            ->count();
    }
}
