<?php

namespace App\Listeners\News;

use App\Enums\UserNotificationSubscriptions;
use App\Events\News\NewsCreated;
use App\Mail\NewsNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewsNotificationEmail implements ShouldQueue
{
    public function handle(NewsCreated $event)
    {
        if (!config('mail.enabled')) {
            return;
        }

        if (!$event->notify_users) {
            return;
        }

        Mail::to(
            User::hasFlag('notification_subscriptions', UserNotificationSubscriptions::NewsNotifications)
            ->whereNotNull('email')->select('email')->get()
        )
            ->later($event->news->date, new NewsNotification($event->news));
    }
}
