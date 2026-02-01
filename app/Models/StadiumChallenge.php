<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StadiumChallenge extends Model
{
    protected $fillable = [
        'game_id',
        'image_path',
        'stadium_name',
        'capacity',
        'opened_year',
        'country',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['description'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function hints(): HasMany
    {
        return $this->hasMany(StadiumHint::class)->orderBy('sort_order');
    }

    public function getDescriptionAttribute(): string
    {
        $parts = [];
        
        if ($this->capacity) {
            $parts[] = number_format($this->capacity) . "-capacity";
        }
        
        if ($this->opened_year) {
            $parts[] = "opened in " . $this->opened_year;
        }
        
        if ($this->country) {
            $parts[] = "located in " . $this->country;
        }
        
        if (empty($parts)) {
            return "This stadium is home to some of football's greatest moments.";
        }
        
        return "This " . implode(", ", $parts) . " stadium is home to some of football's greatest moments.";
    }
}
