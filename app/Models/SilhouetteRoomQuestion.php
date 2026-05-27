<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SilhouetteRoomQuestion extends Model
{
    protected $fillable = [
        'room_id',
        'challenge_id',
        'question_order',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'question_order' => 'integer',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(SilhouetteRoom::class, 'room_id');
    }

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SilhouetteAnswer::class, 'room_question_id');
    }

    public function isActive(): bool
    {
        return $this->started_at !== null && $this->ended_at === null;
    }
}
