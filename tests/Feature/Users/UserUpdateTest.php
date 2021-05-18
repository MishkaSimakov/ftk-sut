<?php

namespace Tests\Feature\Users;

use App\Enums\UserNotificationSubscriptions;
use App\Models\User;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    public function test_it_requires_email()
    {
        $user = User::factory()->create();

        auth()->login($user);

        $this->put(route('users.update', $user))
            ->assertSessionHasErrors('email');
    }

    public function test_it_requires_email_to_be_valid()
    {
        $user = User::factory()->create();

        auth()->login($user);

        $this->put(route('users.update', $user), [
            'email' => 'abc'
        ])
            ->assertSessionHasErrors('email');
    }

    public function test_it_requires_email_to_be_unique()
    {
        User::factory()->create([
            'email' => $email = 'msimakov661@gmail.com'
        ]);

        $user = User::factory()->create();

        auth()->login($user);

        $this->put(route('users.update', $user), [
            'email' => $email
        ])
            ->assertSessionHasErrors('email');
    }

    public function test_it_updates_email()
    {
        $user = User::factory()->create([
            'email' => 'msimakov661@gmail.com'
        ]);

        auth()->login($user);

        $this->put(route('users.update', $user), [
            'email' => $email = 'abc@gmail.com'
        ]);

        $this->assertEquals($email, $user->fresh()->email);
    }

    public function test_it_updates_subscriptions()
    {
        $user = User::factory()->create([
            'notification_subscriptions' => UserNotificationSubscriptions::flags([])
        ]);

        auth()->login($user);

        $this->put(route('users.update', $user), [
            'email' => 'abc@gmail.com',
            'noticeNews' => 'on'
        ]);

        $this->assertTrue($user->fresh()->notification_subscriptions->hasFlag(UserNotificationSubscriptions::NewsNotifications));
        $this->assertTrue($user->fresh()->notification_subscriptions->notHasFlags([
            UserNotificationSubscriptions::RatingNotifications(),
            UserNotificationSubscriptions::ArticleNotifications(),
            UserNotificationSubscriptions::EventNotifications(),
        ]));
    }
}
