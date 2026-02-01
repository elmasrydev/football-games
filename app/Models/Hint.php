<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hint extends Model
{
    protected $fillable = ['video_id', 'content', 'sort_order'];

    public function video(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
