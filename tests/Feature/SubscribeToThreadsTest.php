<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{

    public function test_a_user_can_subscribe_to_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = Thread::factory()->create();

        $this->post($thread->path() . "/subscriptions");

        $this->assertCount(1, $thread->subscriptions);
    }

    public function test_a_user_can_unsubscribe_from_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        /** @var Thread $thread */
        $thread = Thread::factory()->create();

        $thread->subscribe();

        $this->delete($thread->path() . "/subscriptions");

        $this->assertCount(0, $thread->subscriptions);
    }
}
