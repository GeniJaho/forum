<?php

namespace Tests\Feature;


use App\Models\Thread;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    public function test_it_increments_a_threads_score_every_time_it_is_read()
    {
        $this->assertEmpty(Thread::trending()->get());

        $thread = Thread::factory()->create();

        $this->get($thread->path());

        $trending = Thread::trending()->get();

        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
