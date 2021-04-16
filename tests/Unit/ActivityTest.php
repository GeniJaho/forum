<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    public function test_it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = Thread::factory()->create(['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        Reply::factory()->create();

        $this->assertEquals(2, Activity::count());
    }
}
