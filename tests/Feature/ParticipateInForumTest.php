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

    public function test_unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = Reply::factory()->create();

        $this->delete(route('replies.destroy', $reply->id))
            ->assertRedirect('login');

        $this->signIn()
            ->delete(route('replies.destroy', $reply->id))
            ->assertStatus(403);
    }

    public function test_authorized_users_can_delete_replies()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = Reply::factory()->create(['user_id' => auth()->id()]);

        $this->delete(route('replies.destroy', $reply->id))
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_authorized_users_can_update_replies()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = Reply::factory()->create(['user_id' => auth()->id()]);

        $updatedReply = 'You been changed, fool';

        $this->patch(route('replies.update', $reply->id), [
            'body' => $updatedReply
        ]);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id, 'body' => $updatedReply
        ]);
    }

    public function test_unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = Reply::factory()->create();

        $updatedReply = 'You been changed, fool';

        $this->patch(route('replies.update', $reply->id), [
            'body' => $updatedReply
        ])->assertRedirect('login');

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id, 'body' => $reply->body
        ]);

        $this->signIn();

        $this->patch(route('replies.update', $reply->id), [
            'body' => $updatedReply
        ])->assertStatus(403);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id, 'body' => $reply->body
        ]);
    }
}
