<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{

    public function test_non_admins_may_not_lock_threads()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))
            ->assertForbidden();

        $this->assertFalse($thread->fresh()->locked);
    }

    public function test_admins_may_lock_threads()
    {
        $this->signIn(User::factory()->admin()->create());

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertOk();

        $this->assertTrue($thread->fresh()->locked);
    }

    public function test_admins_may_unlock_threads()
    {
        $this->signIn(User::factory()->admin()->create());

        $thread = Thread::factory()->create([
            'user_id' => auth()->id(),
            'locked' => true
        ]);

        $this->delete(route('locked-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->locked);
    }

    public function test_once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['locked' => true]);

        $this->postJson(route('replies.store', [$thread->channel, $thread]), [
            'body' => 'test',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
