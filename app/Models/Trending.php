<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Collection;

class Trending
{
    public function get(): Collection
    {
        return Thread::trending()->get();
    }

    public function push(Thread $thread)
    {
        $thread->visit();
    }
}
