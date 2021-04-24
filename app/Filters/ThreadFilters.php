<?php


namespace App\Filters;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * @param $username
     * @return Builder
     */
    protected function by($username): Builder
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * @return Builder
     */
    protected function popular(): Builder
    {
        return $this->builder->reorder('replies_count', 'desc');
    }

    /**
     * @return Builder
     */
    protected function unanswered(): Builder
    {
        return $this->builder->where('replies_count', 0);
    }
}
