<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_subscribe_to_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = Thread::factory()->create();

        $this->post($thread->path() . "/subscriptions");

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some body'
        ]);

        // notification assertion here
    }
}
