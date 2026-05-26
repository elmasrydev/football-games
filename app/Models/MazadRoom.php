<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MazadRoom extends Model
{
    protected $fillable = [
        'code',
        'owner_id',
        'visibility',
        'status',
        'max_players',
        'min_players_to_start',
        'auto_start_at',
        'num_questions',
        'question_time_seconds',
        'rest_time_seconds',
        'mode',
        'num_teams',
        'current_question_index',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'max_players' => 'integer',
        'min_players_to_start' => 'integer',
        'auto_start_at' => 'integer',
        'num_questions' => 'integer',
        'question_time_seconds' => 'integer',
        'rest_time_seconds' => 'integer',
        'num_teams' => 'integer',
        'current_question_index' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (MazadRoom $room) {
            if (empty($room->code)) {
                $room->code = self::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique 6-character alphanumeric room code.
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    // ── Relationships ──

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(MazadPlayer::class, 'room_id');
    }

    public function connectedPlayers(): HasMany
    {
        return $this->players()->where('is_connected', true);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(MazadTeam::class, 'room_id');
    }

    public function roomQuestions(): HasMany
    {
        return $this->hasMany(MazadRoomQuestion::class, 'room_id')->orderBy('question_order');
    }

    // ── Helpers ──

    public function currentRoomQuestion(): ?MazadRoomQuestion
    {
        return $this->roomQuestions()
            ->where('question_order', $this->current_question_index)
            ->first();
    }

    public function playerCount(): int
    {
        return $this->players()->count();
    }

    public function isFull(): bool
    {
        return $this->playerCount() >= $this->max_players;
    }

    public function canStart(): bool
    {
        return $this->playerCount() >= $this->min_players_to_start
            && $this->status === 'waiting';
    }

    public function isJoinable(): bool
    {
        return $this->status === 'waiting' && !$this->isFull();
    }

    public function hasPlayer(int $userId): bool
    {
        return $this->players()->where('user_id', $userId)->exists();
    }

    public function getPlayer(int $userId): ?MazadPlayer
    {
        return $this->players()->where('user_id', $userId)->first();
    }

    /**
     * Get the shareable link for this room.
     */
    public function getShareLinkAttribute(): string
    {
        $locale = app()->getLocale();
        return url("/{$locale}/mazad/room/{$this->code}");
    }
}
