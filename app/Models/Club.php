<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    protected $fillable = [
        'name',
        'logo_url',
        'country',
        'league',
    ];

    public function careerClubs(): HasMany
    {
        return $this->hasMany(CareerClub::class);
    }
}
