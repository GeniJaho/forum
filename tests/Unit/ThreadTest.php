<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = Thread::factory()->create();
    }


    public function testAThreadCanMakeAStringPath()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAThreadHasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAThreadHasACreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function testAThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testAThreadBelongsToAChannel()
    {
        $this->assertInstanceOf('App\Models\Channel', $this->thread->channel);
    }
}
