<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Genre extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'slug',
        'icon',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function games(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMediaUrl('cover');
        if ($media) {
            return $media;
        }

        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return null;
    }

    public function getGamesCountAttribute(): int
    {
        return $this->games()->where('is_active', true)->count();
    }

    public function scopeActiveWithChallenges($query, $args = null)
    {
        $query = $query->where('is_active', true);
        $language = is_array($args) ? ($args['language'] ?? null) : $args;
        
        if ($language) {
            return $query->whereHas('challenges', function($q) use ($language) {
                $q->where('language', $language)->where('is_active', true);
            });
        }
        return $query->has('challenges');
    }

    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->name_ar ?: $this->name_en)
            : $this->name_en;
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->description_ar ?: $this->description_en)
            : $this->description_en;
    }
}
