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
        return $this->hasMany(CareerClub::class);
    }
}
