<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{

    public function test_a_thread_requires_a_title_and_a_body_to_be_updated()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->patch(route('threads.update', [$thread->channel, $thread]), [
            'title' => 'asdf',
        ])->assertSessionHasErrors('body');

        $this->patch(route('threads.update', [$thread->channel, $thread]), [
            'body' => 'asdf',
        ])->assertSessionHasErrors('title');
    }

    public function test_a_thread_can_be_updated_by_its_owner()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->patch(route('threads.update', [$thread->channel, $thread]), [
            'title' => 'Changed',
            'body' => 'Changed body'
        ]);

        $thread->refresh();

        $this->assertEquals('Changed', $thread->title);
        $this->assertEquals('Changed body', $thread->body);
    }

    public function test_unauthorized_users_may_not_update_threads()
    {
        $this->signIn();

        $thread = Thread::factory()->create(
            ['user_id' => User::factory()->create()->id]
        );

        $this->patch(route('threads.update', [$thread->channel, $thread]))
            ->assertForbidden();
    }
}
