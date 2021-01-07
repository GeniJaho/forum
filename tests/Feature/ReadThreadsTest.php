<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    /**
     * @var Collection|Model|mixed
     */
    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = Thread::factory()->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAUserCanBrowseAllThreads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testAUserCanBrowseASingleThread()
    {
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesAssociatedWithAThread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);
        $response = $this->get($this->thread->path())
            ->assertSee($reply->body);

    }
}
