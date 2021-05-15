<?php

namespace Tests\Feature;

use App\Models\Channel;
use Tests\TestCase;

class ReadChannelsTest extends TestCase
{
    public function test_any_user_can_read_all_the_channels()
    {
        Channel::factory(2)->create();

        $response = $this->getJson(route('channels.index'))
            ->assertOk()
            ->json();

        $this->assertCount(2, $response);
    }
}
