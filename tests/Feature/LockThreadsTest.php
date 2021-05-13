<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{

    public function test_an_administrator_can_lock_any_thread()
    {
        $this->signIn();

          $thread = Thread::factory()->create();

          $thread->lock();

          $this->postJson(route('replies.store', [$thread->channel, $thread]), [
              'body' => 'test',
              'user_id' => auth()->id()
          ])->assertStatus(422);
    }
}
