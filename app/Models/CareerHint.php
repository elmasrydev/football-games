<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerHint extends Model
{
    protected $fillable = [
        'career_challenge_id',
        'content',
        'sort_order',
    ];

    public function careerChallenge(): BelongsTo
    {
        return $this->belongsTo(CareerChallenge::class);
    }
}
