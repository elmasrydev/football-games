<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CareerChallenge extends Model
{
    protected $fillable = [
        'game_id',
        'player_name',
        'player_image',
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

    public function careerClubs(): HasMany
    {
        return $this->hasMany(CareerClub::class)->orderBy('sort_order');
    }

    public function hints(): HasMany
    {
        return $this->hasMany(CareerHint::class)->orderBy('sort_order');
    }

    /**
     * Get the career chain as an array of club names with years
     */
    public function getCareerChainAttribute(): array
    {
        return $this->careerClubs->map(function ($careerClub) {
            return [
                'club' => $careerClub->club->name,
                'logo' => $careerClub->club->logo_url,
                'year' => $careerClub->join_year,
            ];
        })->toArray();
    }

    /**
     * Get a formatted description of the career path
     */
    public function getCareerPathDescriptionAttribute(): string
    {
        $clubs = $this->careerClubs;
        
        if ($clubs->isEmpty()) {
            return 'Career path not set';
        }

        return $clubs->map(function ($careerClub) {
            return $careerClub->club->name . ' (' . $careerClub->join_year . ')';
        })->join(' → ');
    }
}
