<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    protected $guarded = [];

    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param $reply
     * @return Reply
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where([
                'user_id' => $userId ?? auth()->id()
            ])
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
}
