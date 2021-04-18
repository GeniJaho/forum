<?php

namespace App\Traits;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;

trait Favorable {

    protected static function bootFavorable()
    {
        if (auth()->guest()) {
            return;
        }

        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    /**
     * @return mixed
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * @return Model|null
     */
    public function favorite(): ?Model
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }

        return null;
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
