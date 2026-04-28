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
        'is_active',
    ];

    protected $casts = [
        'stimulus_data' => 'array',
        'answers' => 'array',
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
        return $this->hasMany(ChallengeHint::class)->orderBy('sort_order');
    }

    // ── Accessors for specific game types ──

    /**
     * Vowel Void: compute consonant display from answer
     */
    public function getConsonantDisplayAttribute(): string
    {
        return preg_replace('/[aeiou]/i', '_', $this->answer);
    }

    /**
     * Get image path from stimulus_data
     */
    public function getImagePathAttribute(): ?string
    {
        return $this->stimulus_data['image_path'] ?? null;
    }

    /**
     * Get video URL from stimulus_data
     */
    public function getYoutubeUrlAttribute(): ?string
    {
        return $this->stimulus_data['youtube_url'] ?? null;
    }

    /**
     * Get YouTube video ID
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = $this->youtube_url;
        if (!$url) return null;
        preg_match('/(?:v=|\/embed\/|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get question from stimulus_data (for video quiz, glossary)
     */
    public function getQuestionAttribute(): ?string
    {
        return $this->stimulus_data['question'] ?? $this->stimulus_data['clue'] ?? null;
    }

    /**
     * Scrambled word for anagrams
     */
    public function getScrambledWordAttribute(): ?string
    {
        return $this->stimulus_data['scrambled_word'] ?? null;
    }

    /**
     * Missing link parts
     */
    public function getPartAAttribute(): ?string
    {
        return $this->stimulus_data['part_a'] ?? null;
    }

    public function getPartBAttribute(): ?string
    {
        return $this->stimulus_data['part_b'] ?? null;
    }

    /**
     * Transfer chain clubs
     */
    public function getClubAAttribute(): ?string
    {
        return $this->stimulus_data['club_a'] ?? null;
    }

    public function getClubBAttribute(): ?string
    {
        return $this->stimulus_data['club_b'] ?? null;
    }

    /**
     * Career path clubs data
     */
    public function getCareerClubsAttribute(): ?array
    {
        return $this->stimulus_data['clubs'] ?? null;
    }

    /**
     * Group challenge data
     */
    public function getGroupTitleAttribute(): ?string
    {
        return $this->stimulus_data['title'] ?? null;
    }

    public function getGroupPlayersAttribute(): ?array
    {
        return $this->stimulus_data['players'] ?? null;
    }

    /**
     * Unified answers array for multi-answer games
     */
    public function getAnswersArrayAttribute(): array
    {
        return $this->answers ?? $this->stimulus_data['players'] ?? [];
    }


    /**
     * Stadium metadata
     */
    public function getCapacityAttribute(): ?int
    {
        return $this->stimulus_data['capacity'] ?? null;
    }

    public function getCountryAttribute(): ?string
    {
        return $this->stimulus_data['country'] ?? null;
    }

    public function getOpenedYearAttribute(): ?int
    {
        return $this->stimulus_data['opened_year'] ?? null;
    }

    /**
     * Video timing
     */
    public function getStartTimeAttribute(): ?string
    {
        return $this->stimulus_data['start_time'] ?? null;
    }

    public function getEndTimeAttribute(): ?string
    {
        return $this->stimulus_data['end_time'] ?? null;
    }

    /**
     * Vowel void category
     */
    public function getVowelCategoryAttribute(): ?string
    {
        return $this->stimulus_data['category'] ?? null;
    }

    /**
     * Kit / Silhouette reveal image
     */
    public function getRevealImagePathAttribute(): ?string
    {
        return $this->stimulus_data['reveal_image_path'] ?? $this->stimulus_data['full_image_path'] ?? null;
    }

    // ── Backward-compatible aliases ──

    /**
     * player_name alias for answer (used by silhouette, career screens)
     */
    public function getPlayerNameAttribute(): ?string
    {
        return $this->answer;
    }

    /**
     * stadium_name alias for answer (used by stadium screen)
     */
    public function getStadiumNameAttribute(): ?string
    {
        return $this->answer;
    }

    /**
     * team_name alias for answer (used by kit detective screen)
     */
    public function getTeamNameAttribute(): ?string
    {
        return $this->answer;
    }

    /**
     * Stadium description (computed from metadata)
     */
    public function getDescriptionAttribute(): ?string
    {
        $capacity = $this->stimulus_data['capacity'] ?? null;
        $openedYear = $this->stimulus_data['opened_year'] ?? null;
        $country = $this->stimulus_data['country'] ?? null;
        
        if (!$capacity && !$openedYear && !$country) return null;

        $parts = [];
        if ($capacity) $parts[] = number_format($capacity) . "-capacity";
        if ($openedYear) $parts[] = "opened in " . $openedYear;
        if ($country) $parts[] = "located in " . $country;

        return "This " . implode(", ", $parts) . " stadium is home to some of football's greatest moments.";
    }

    // ── Navigation Logic ──
    /**
     * Get the current level number (chronological order by ID)
     */
    public function getCurrentLevelAttribute(): int
    {
        return Challenge::where('game_id', $this->game_id)
            ->where('genre_id', $this->genre_id)
            ->where('is_active', true)
            ->where('id', '<=', $this->id)
            ->count();
    }

    /**
     * Get total levels available for this game and genre
     */
    public function getTotalLevelsAttribute(): int
    {
        return Challenge::where('game_id', $this->game_id)
            ->where('genre_id', $this->genre_id)
            ->where('is_active', true)
            ->count();
    }

    // ── Scopes ──

    public function scopeByGameType($query, string $type)
    {
        return $query->whereHas('game', fn($q) => $q->where('game_type', $type));
    }

    public function scopeByGenre($query, int $genreId)
    {
        return $query->where('genre_id', $genreId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
