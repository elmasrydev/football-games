<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MazadAnswer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'room_question_id',
        'player_id',
        'answer_text',
        'matched_answer',
        'is_correct',
        'submitted_at',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function roomQuestion(): BelongsTo
    {
        return $this->belongsTo(MazadRoomQuestion::class, 'room_question_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(MazadPlayer::class, 'player_id');
    }
}
