<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    public function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

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
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = Thread::factory()->create()->subscribe();

        $thread->addReply([
            'user_id' => User::factory()->create()->id,
            'body' => 'Some body'
        ]);

        /** @var User $user */
        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications");

        $this->assertCount(1, $response->json());
    }

    public function test_a_user_can_mark_a_notification_as_read()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = Thread::factory()->create()->subscribe();

        $thread->addReply([
            'user_id' => User::factory()->create()->id,
            'body' => 'Some body'
        ]);

        /** @var User $user */
        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
