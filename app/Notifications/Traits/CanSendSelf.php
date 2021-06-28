<?php


namespace App\Notifications\Traits;


use Notification;

trait CanSendSelf
{
    public function notify()
    {
        Notification::route('telegram', config('services.telegram-bot-api.channel_id'))
            ->notify($this);
    }
}
