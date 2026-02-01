<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['game_id', 'youtube_url', 'uploaded_video', 'question', 'answer', 'start_time', 'end_time', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function hints(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Hint::class)->orderBy('sort_order');
    }

    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->youtube_url) {
            return null;
        }
        
        preg_match('/(?:v=|\/embed\/|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }
}
