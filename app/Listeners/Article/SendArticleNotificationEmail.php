<?php

namespace App\Listeners\Article;

use App\Enums\UserNotificationSubscriptions;
use App\Events\Article\ArticleFirstTimeChecked;
use App\Mail\ArticleNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendArticleNotificationEmail implements ShouldQueue
{
    public function handle(ArticleFirstTimeChecked $event)
    {
        Mail::to(
            User::hasFlag('notification_subscriptions', UserNotificationSubscriptions::ArticleNotifications)
                ->whereNotNull('email')->select('email')->get()
        )
            ->later($event->article->date, new ArticleNotification($event->article));
    }
}
