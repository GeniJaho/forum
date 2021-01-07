<?php


use App\Models\Channel;
use App\Models\Thread;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function test_a_channel_consists_of_threads()
    {
        $channel = Channel::factory()->create();
        $thread = Thread::factory()->create(['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
