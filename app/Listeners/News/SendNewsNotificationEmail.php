<?php

namespace App\Listeners\News;

use App\Events\NewsCreated;
use App\Mail\NewsNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendNewsNotificationEmail
{
    public function handle(NewsCreated $event)
    {
        if (!$event->notify_users) {
            return;
        }

        Mail::to(User::whereNotNull('email')->select('email')->get())
            ->later(now()->addMinutes(5), new NewsNotification($event->news));
    }
}
