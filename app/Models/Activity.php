<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * @param $model
     * @return Collection
     */
    public static function feed($model): Collection
    {
        return $model->activity()
            ->with('subject')
            ->latest()
            ->take(50)
            ->get();
    }
}
