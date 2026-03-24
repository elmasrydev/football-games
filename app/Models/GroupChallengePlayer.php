<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupChallengePlayer extends Model
{
    protected $fillable = [
        'group_challenge_id',
        'player_name',
        'sort_order',
    ];

    public function groupChallenge(): BelongsTo
    {
        return $this->belongsTo(GroupChallenge::class);
    }
}
