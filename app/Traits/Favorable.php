<?php

namespace App\Traits;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;

trait Favorable {

    /**
     * @return mixed
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * @return bool
     */
    public function isFavorited(): bool
    {
        return $this->favorites->where(['user_id' => auth()->id()])->isNotEmpty();
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
