<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    private Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = Thread::factory()->create();
    }


    public function test_a_thread_has_a_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->slug}", $this->thread->path());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 654654
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Models\Channel', $this->thread->channel);
    }

    public function test_a_thread_can_be_subscribed_to()
    {
        $thread = Thread::factory()->create();

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    public function test_a_thread_can_be_unsubscribed_from()
    {
        $thread = Thread::factory()->create();

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    public function test_it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = Thread::factory()->create();

        $this->assertFalse($thread->isSubscribedTo);

        $this->signIn();

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    /**
     * @throws Exception
     */
    public function test_a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = Thread::factory()->create();

        /** @var User $user */
        $user = auth()->user();

        $this->assertTrue($thread->hasUpdatesFor($user));

        $user->read($thread);

        $this->assertFalse($thread->hasUpdatesFor($user));
    }

    public function test_a_thread_records_each_visit()
    {
        /** @var Thread $thread */
        $thread = Thread::factory()->create();

        $this->assertEquals(0, $thread->visits);

        $thread->visit();
        $thread->visit();
        $thread->visit();

        $this->assertEquals(3, $thread->fresh()->visits);
    }

    public function test_a_threads_body_is_sanitized_automatically()
    {
        $thread = Thread::factory()->makeOne([
            'body' => '<script>alert("Harmful Script");</script> <p style="a style" class="a-different-class">Test</p>'
        ]);

        $this->assertEquals(' <p>Test</p>', $thread->body);
    }
}
