<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SilhouettePlayer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'user_id',
        'team_id',
        'is_owner',
        'is_connected',
        'total_score',
        'joined_at',
        'disconnected_at',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
        'is_connected' => 'boolean',
        'total_score' => 'integer',
        'joined_at' => 'datetime',
        'disconnected_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(SilhouetteRoom::class, 'room_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(SilhouetteTeam::class, 'team_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SilhouetteAnswer::class, 'player_id');
    }

    public function correctCountForQuestion(int $roomQuestionId): int
    {
        return $this->answers()
            ->where('room_question_id', $roomQuestionId)
            ->where('is_correct', true)
            ->distinct('game_item_id')
            ->count('game_item_id');
    }
}
