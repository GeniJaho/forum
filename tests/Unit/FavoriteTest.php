<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
use Tests\TestCase;

class FavoriteTest extends TestCase
{

    public function test_a_favorite_knows_its_owner_model()
    {
        $this->signIn();

        /** @var Reply $reply */
        $reply = Reply::factory()->create();

        /** @var Favorite $favorite */
        $favorite = $reply->favorite();

        $this->assertTrue($reply->is($favorite->favorited));
    }
}
