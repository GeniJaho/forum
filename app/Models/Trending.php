<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Collection;

class Trending
{
    public function get(int $top = 5): Collection
    {
        return Thread::query()
            ->where('visits', '>', 0)
            ->orderByDesc('visits')
            ->take($top)
            ->get();
    }

    public function push(Thread $thread)
    {
        $thread->visit();
    }
}
