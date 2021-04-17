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

    public function test_it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        Thread::factory(2)->create(['user_id' => auth()->id()]);

        auth()->user()->activity()->first()->update(['created_at' => now()->subWeek()]);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            now()->subWeek()->format('Y-m-d')
        ));
    }
}
