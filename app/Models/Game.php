<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Game extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'genre_id',
        'title',
        'name_ar',
        'slug',
        'description',
        'image',
        'game_type',
        'answer_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMediaUrl('cover');
        return $media ?: ($this->image ? asset('storage/' . $this->image) : null);
    }
}
