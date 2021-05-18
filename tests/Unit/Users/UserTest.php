<?php

namespace Tests\Unit\Users;

use App\Enums\UserNotificationSubscriptions;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_it_has_notification_subscriptions()
    {
        $user = User::factory()->create([
            'notification_subscriptions' => UserNotificationSubscriptions::flags([])
        ]);

        $this->assertInstanceOf(UserNotificationSubscriptions::class, $user->notification_subscriptions);
    }
}
