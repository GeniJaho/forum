<?php

namespace Tests\Feature;

use App\Models\Channel;
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
    public function test_a_user_can_browse_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_browse_a_single_thread()
    {
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);
        $response = $this->get($this->thread->path())
            ->assertSee($reply->body);

    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = Channel::factory()->create();
        $threadInChannel = Thread::factory()->create(['channel_id' => $channel->id]);
        $threadNotInChannel = Thread::factory()->create();

        $this->get("/threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
