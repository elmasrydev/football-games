<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KitHint extends Model
{
    protected $fillable = [
        'kit_challenge_id',
        'content',
        'sort_order',
    ];

    public function kitChallenge(): BelongsTo
    {
        return $this->belongsTo(KitChallenge::class);
    }
}
