<?php

namespace Tests\Feature;


use App\Models\Thread;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Redis::del('trending_threads');
    }

    public function test_it_increments_a_threads_score_every_time_it_is_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads', 0, -1));

        $thread = Thread::factory()->create();

        $this->get($thread->path());

        $trending = Redis::zrevrange('trending_threads', 0, -1);

        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }
}
