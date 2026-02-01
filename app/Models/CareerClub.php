<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerClub extends Model
{
    protected $fillable = [
        'career_challenge_id',
        'club_id',
        'join_year',
        'sort_order',
    ];

    public function careerChallenge(): BelongsTo
    {
        return $this->belongsTo(CareerChallenge::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
