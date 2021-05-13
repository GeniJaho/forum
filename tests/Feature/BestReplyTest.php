<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class BestReplyTest extends TestCase
{

    public function test_a_thread_creator_may_mark_any_reply_as_the_best_reply()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $replies = Reply::factory(2)
            ->for($thread)
            ->create();

        $this->assertFalse($replies[1]->fresh()->isBest());

        $this->postJson(route('best-replies.store', $replies[1]->id));

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    public function test_only_the_thread_creator_may_mark_a_reply_as_best()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $replies = Reply::factory(2)
            ->for($thread)
            ->create();

        $this->signIn(User::factory()->create());

        $this->postJson(route('best-replies.store', $replies[1]->id))
            ->assertForbidden();

        $this->assertFalse($replies[1]->fresh()->isBest());
    }

    public function test_if_a_best_reply_is_deleted_then_the_thread_is_probably_updated_to_reflect_that()
    {
        $this->signIn();

        /** @var Reply $reply */
        $reply = Reply::factory()->create(['user_id' => auth()->id()]);

        $reply->thread->markBestReply($reply);

        $this->deleteJson(route('replies.destroy', $reply));

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
