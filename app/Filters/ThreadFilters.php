<?php


namespace App\Filters;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];

    /**
     * @param $username
     * @return Builder
     */
    protected function by($username): Builder
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
