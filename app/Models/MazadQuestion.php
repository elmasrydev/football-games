<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MazadQuestion extends Model
{
    protected $fillable = [
        'text',
        'text_ar',
        'category',
        'difficulty',
        'accepted_answers',
    ];

    protected $casts = [
        'accepted_answers' => 'array',
    ];

    public function roomQuestions(): HasMany
    {
        return $this->hasMany(MazadRoomQuestion::class, 'question_id');
    }

    /**
     * Get the associated GameItem models for accepted answers.
     */
    public function acceptedGameItems()
    {
        return \App\Models\GameItem::whereIn('id', $this->accepted_answers ?? [])->get();
    }

    /**
     * Get localized question text.
     */
    public function getLocalizedTextAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->text_ar ?: $this->text)
            : $this->text;
    }
}
