<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MazadRoomQuestion extends Model
{
    protected $fillable = [
        'room_id',
        'question_id',
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
        return $this->belongsTo(MazadRoom::class, 'room_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(MazadQuestion::class, 'question_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(MazadAnswer::class, 'room_question_id');
    }

    /**
     * Check if this question round is currently active.
     */
    public function isActive(): bool
    {
        return $this->started_at !== null && $this->ended_at === null;
    }
}
