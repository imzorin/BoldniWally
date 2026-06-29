<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'anime_id',
        'anime_title',
        'rating',
        'review'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
