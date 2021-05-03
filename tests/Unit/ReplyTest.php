<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{

    public function test_it_has_an_owner()
    {
        $reply = Reply::factory()->create();
        $this->assertInstanceOf(User::class, $reply->owner);
    }

    public function test_it_knows_if_it_was_just_published()
    {
        $reply = Reply::factory()->create();

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }
}
