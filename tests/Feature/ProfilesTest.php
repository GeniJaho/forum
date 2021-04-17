<?php


use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ProfilesTest extends TestCase
{

    public function test_a_user_has_a_profile()
    {
        $user = User::factory()->create();

        $this->get(route('profile', $user->name))
            ->assertSee($user->name);
    }

    public function test_profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->get(route('profile', auth()->user()->name))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
