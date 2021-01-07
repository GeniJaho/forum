<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function testUnauthenticatedUsersMayNotPostReplies()
    {
        $this->post('/threads/nice/1/replies', [])
        ->assertRedirect('/login');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->be($user = User::factory()->create());

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->makeOne();

        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
