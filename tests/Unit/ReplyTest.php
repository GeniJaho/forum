<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_an_owner()
    {
        $reply = Reply::factory()->create();
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
