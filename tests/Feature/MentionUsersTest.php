<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{

    public function test_mentioned_users_in_a_reply_are_notified()
    {
        $john = User::factory()->create(['name' => 'JohnDoe']);
        $jane = User::factory()->create(['name' => 'JaneDoe']);

        $this->signIn($john);

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->for($thread)->makeOne([
            'body' => "@JaneDoe look at this."
        ]);

        $this->postJson($thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    public function test_it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        User::factory()->create(['name' => 'johndoe']);
        User::factory()->create(['name' => 'johndoe2']);
        User::factory()->create(['name' => 'janedoe']);

        $response = $this->getJson('api/users?name=john');

        $this->assertCount(2, $response->json());
    }
}
