<?php

use App\Models\Reply;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = User::factory()->create();

        $reply = Reply::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function test_a_user_can_determine_their_avatar_path()
    {
        $user = User::factory()->create();

        $this->assertEquals(
            asset('img/avatars/default.png'),
            $user->avatar_path
        );

        $user = User::factory()->create(['avatar_path' => 'avatars/me.jpg']);

        $this->assertEquals(
            asset('storage/avatars/me.jpg'),
            $user->avatar_path
        );
    }
}
