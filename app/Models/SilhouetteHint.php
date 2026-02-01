<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SilhouetteHint extends Model
{
    protected $fillable = [
        'silhouette_challenge_id',
        'content',
        'sort_order',
    ];

    public function silhouetteChallenge(): BelongsTo
    {
        return $this->belongsTo(SilhouetteChallenge::class);
    }
}
