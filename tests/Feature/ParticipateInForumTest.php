<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function test_unauthenticated_users_may_not_post_replies()
    {
        $this->post('/threads/nice/1/replies', [])
            ->assertRedirect('/login');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = User::factory()->create());

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne();

        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    public function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne(['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
