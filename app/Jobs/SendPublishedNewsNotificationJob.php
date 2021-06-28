<?php

namespace App\Jobs;

use App\Models\News;
use App\Notifications\NewsPublishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPublishedNewsNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        News::all()->each(function (News $news) {
            if (!$news->notification_sent) {
                (new NewsPublishedNotification($news))->notify();

                $news->update([
                    'notification_sent' => true
                ]);
            }
        });
    }
}
