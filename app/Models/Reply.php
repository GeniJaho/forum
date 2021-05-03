<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    use Favorable;
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function wasJustPublished(): bool
    {
        return $this->created_at->gt(now()->subMinute());
    }
}
