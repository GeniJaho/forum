<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @throws Exception
     */
    public function read(Thread $thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            now()
        );
    }

    public function visitedThreadCacheKey(Thread $thread): string
    {
        return sprintf("user.%s.visits.%s", $this->id, $thread->id);
    }
}
