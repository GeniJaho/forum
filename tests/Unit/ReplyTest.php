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

    public function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = Reply::factory()->makeOne([
            'body' => '@JaneDoe mentions @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    public function test_it_wraps_mentioned_usernames_within_anchor_tags()
    {
        $reply = Reply::factory()->makeOne([
            'body' => 'Hello @Jane-Doe.'
        ]);

        $this->assertEquals(
            "Hello <a href='/profiles/Jane-Doe'>@Jane-Doe</a>.",
            $reply->body
        );
    }

    public function test_it_knows_if_it_is_the_best_reply()
    {
        /** @var Reply $reply */
        $reply = Reply::factory()->create();

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->isBest());
    }
}
