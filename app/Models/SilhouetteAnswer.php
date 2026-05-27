<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SilhouetteAnswer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'room_question_id',
        'player_id',
        'answer_text',
        'game_item_id',
        'is_correct',
        'is_winning',
        'submitted_at',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_winning' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function roomQuestion(): BelongsTo
    {
        return $this->belongsTo(SilhouetteRoomQuestion::class, 'room_question_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(SilhouettePlayer::class, 'player_id');
    }

    public function gameItem(): BelongsTo
    {
        return $this->belongsTo(GameItem::class, 'game_item_id');
    }
}
