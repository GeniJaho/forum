<?php

namespace Tests\Feature;

use App\Models\Reply;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function test_guests_can_not_favorite_anything()
    {
        $this->post("/replies/1/favorites")
            ->assertRedirect('login');
    }

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = Reply::factory()->create();

        $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = Reply::factory()->create();

        $this->post("/replies/{$reply->id}/favorites");
        $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }
}
