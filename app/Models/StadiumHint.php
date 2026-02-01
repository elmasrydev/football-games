<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StadiumHint extends Model
{
    protected $fillable = [
        'stadium_challenge_id',
        'content',
        'sort_order',
    ];

    public function stadiumChallenge(): BelongsTo
    {
        return $this->belongsTo(StadiumChallenge::class);
    }
}
