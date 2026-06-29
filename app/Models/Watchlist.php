<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watchlist extends Model
{
    public const STATUSES = [
        'plan_to_watch',
        'watching',
        'completed',
        'dropped',
    ];

    protected $fillable = [
        'user_id',
        'anime_id',
        'title',
        'image',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
