<?php

namespace App\Listeners\Rating;

use App\Enums\UserNotificationSubscriptions;
use App\Events\Rating\RatingCreated;
use App\Mail\RatingNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendRatingNotificationEmail
{
    public function handle(RatingCreated $event)
    {
        Mail::to(
            User::hasFlag('notification_subscriptions', UserNotificationSubscriptions::RatingNotifications)
                ->whereNotNull('email')->select('email')->get()
        )
            ->send(new RatingNotification($event->date));
    }
}
