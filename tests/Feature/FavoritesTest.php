<?php

namespace Tests\Feature;

use App\Models\Reply;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function test_guests_can_not_favorite_anything()
    {
        $this->post(route('replies.favorite', 1))
            ->assertRedirect('login');
    }

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = Reply::factory()->create();

        $this->post(route('replies.favorite', $reply));

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = Reply::factory()->create();

        $this->post(route('replies.favorite', $reply));
        $this->post(route('replies.favorite', $reply));

        $this->assertCount(1, $reply->favorites);
    }
}
