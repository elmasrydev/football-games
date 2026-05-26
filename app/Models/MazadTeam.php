<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MazadTeam extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'color',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(MazadRoom::class, 'room_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(MazadPlayer::class, 'team_id');
    }
}
