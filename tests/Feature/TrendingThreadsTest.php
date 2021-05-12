<?php

namespace Tests\Feature;


use App\Models\Thread;
use App\Models\Trending;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    protected Trending $trending;

    protected function setUp(): void
    {
        parent::setUp();

        $this->trending = app(Trending::class);
    }

    public function test_it_increments_a_threads_score_every_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());

        $thread = Thread::factory()->create();

        $this->get($thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
