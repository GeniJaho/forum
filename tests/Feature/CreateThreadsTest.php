<?php

namespace Tests\Feature;

use App\Models\Channel;
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

    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = Thread::factory()->make($overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
