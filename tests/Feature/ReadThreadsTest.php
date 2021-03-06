<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = Channel::factory()->create();
        $threadInChannel = Thread::factory()->create(['channel_id' => $channel->id]);
        $threadNotInChannel = Thread::factory()->create();

        $this->get("/threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(User::factory()->create(['name' => 'JohnDoe']));

        $threadByJohn = Thread::factory()->create(['user_id' => auth()->id()]);
        $threadNotByJohn = Thread::factory()->create();

        $this->get(route('threads.index') . "?by=" . auth()->user()->name)
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function test_a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = Thread::factory()->create();
        Reply::factory(2)->create(['thread_id' => $threadWithTwoReplies->id]);

        $threadWithThreeReplies = Thread::factory()->create();
        Reply::factory(3)->create(['thread_id' => $threadWithThreeReplies->id]);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    public function test_a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $threadWithReplies = Thread::factory()->create();

        Reply::factory()->create(['thread_id' => $threadWithReplies->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = Thread::factory()->create();

        Reply::factory(2)->for($thread)->create();

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    public function test_a_new_visit_is_recorded_each_time_a_thread_is_read()
    {
        $thread = Thread::factory()->create();

        $this->assertEquals(0, $thread->visits);

        $this->get($thread->path());

        $this->assertEquals(1, $thread->fresh()->visits);
    }
}
