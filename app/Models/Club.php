<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    protected $primaryKey = 'club_id';
    public $incrementing = false;

    protected $fillable = [
        'club_id',
        'club_code',
        'name',
        'logo',
        'domestic_competition_id',
        'total_market_value',
        'squad_size',
        'average_age',
        'foreigners_number',
        'foreigners_percentage',
        'national_team_players',
        'stadium_name',
        'stadium_seats',
        'net_transfer_record',
        'coach_name',
        'last_season',
        'filename',
        'url',
    ];

    public function careerClubs(): HasMany
    {
        return $this->hasMany(CareerClub::class, 'club_id', 'club_id');
    }

    public function getLogoUrlAttribute(): ?string
    {
        // "Normal data" club logo (external URL based on club_id)
        $normalLogo = "https://images.transfermarkt.at/images/logo/norm/{$this->club_id}.png";

        // Fallback to admin uploaded logo if normal data is not what we want
        // or if we want to prioritize it (user said first try normal then fallback to admin)
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        return $normalLogo;
    }
}
