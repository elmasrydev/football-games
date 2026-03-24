<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupChallengeHint extends Model
{
    protected $fillable = [
        'group_challenge_id',
        'content',
        'sort_order',
    ];

    public function groupChallenge(): BelongsTo
    {
        return $this->belongsTo(GroupChallenge::class);
    }
}
