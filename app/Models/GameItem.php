<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItem extends Model
{
    protected $fillable = [
        'type',
        'name_en',
        'name_ar',
        'country',
        'external_id',
        'metadata',
        'fuzzy_variants',
        'is_active',
    ];

    protected $casts = [
        'metadata' => 'json',
        'fuzzy_variants' => 'json',
        'is_active' => 'boolean',
    ];

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name_en', 'LIKE', "%{$term}%");
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
