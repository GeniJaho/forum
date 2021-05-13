<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Thread thread
 */
class Reply extends Model
{
    use HasFactory;
    use Favorable;
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = [
        'favoritesCount',
        'isFavorited',
        'isBest'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function isBest(): bool
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function wasJustPublished(): bool
    {
        return $this->created_at->gt(now()->subMinute());
    }

    public function mentionedUsers(): array
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            "<a href='/profiles/$1'>$0</a>",
            $body
        );
    }

    public function getIsBestAttribute(): bool
    {
        return $this->isBest();
    }
}
