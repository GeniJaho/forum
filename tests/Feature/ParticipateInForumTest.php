<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Exception;
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
        $this->signIn();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne();

        $this->postJson($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    public function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne(['body' => null]);

        $this->postJson($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
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
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
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

    public function test_replies_that_contain_spam_may_not_be_created()
    {
        $this->signIn();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne([
            'body' => 'Yahoo Customer Support'
        ]);

        $this->postJson($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    public function test_users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->signIn();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne([
            'body' => 'test'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->postJson($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);
    }
}
