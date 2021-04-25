<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Database\Factories\DatabaseNotificationFactory;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->signIn();
    }

    public function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = Thread::factory()->create()->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some body'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => User::factory()->create()->id,
            'body' => 'Some body'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_a_user_can_fetch_their_unread_notifications()
    {
        (new DatabaseNotificationFactory)->create();

        $this->assertCount(
            1,
            $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }

    public function test_a_user_can_mark_a_notification_as_read()
    {
        (new DatabaseNotificationFactory)->create();

        /** @var User $user */
        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $this->delete("/profiles/{$user->name}/notifications/" . $user->unreadNotifications->first()->id);

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
