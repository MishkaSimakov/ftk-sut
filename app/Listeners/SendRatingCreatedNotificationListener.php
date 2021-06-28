<?php

namespace App\Listeners;

use App\Events\Rating\RatingCreated;
use App\Notifications\RatingCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendRatingCreatedNotificationListener
{
    public function handle(RatingCreated $event)
    {
        (new RatingCreatedNotification($event->date))->notify();
    }
}
