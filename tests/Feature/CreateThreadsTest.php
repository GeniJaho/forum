<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function test_guests_may_not_create_threads()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = Thread::factory()->make();

        $response = $this->post(route('threads.store'), $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_thread_requires_a_title()
    {
         $this->publishThread(['title' => null])
         ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body()
    {
         $this->publishThread(['body' => null])
         ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valid_channel()
    {
        Channel::factory(2)->create();

         $this->publishThread(['channel_id' => null])
         ->assertSessionHasErrors('channel_id');

         $this->publishThread(['channel_id' => 999])
         ->assertSessionHasErrors('channel_id');
    }

    public function test_guests_can_not_delete_threads()
    {
        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $response = $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id]);
    }

    public function test_a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $response = $this->deleteJson($thread->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_threads_can_be_deleted_only_by_those_who_have_permission()
    {
        $this->markTestIncomplete();
    }

    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = Thread::factory()->make($overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
