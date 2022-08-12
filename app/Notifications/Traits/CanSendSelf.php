<?php


namespace App\Notifications\Traits;


use Notification;

trait CanSendSelf
{
    public function notify()
    {
        if (config('app.env') === 'testing') {
            return;
        }

        Notification::route('telegram', $this->getChannelId())
            ->notify($this);
    }

    protected function getChannelId()
    {
        return config('services.telegram-bot-api.channel_id');
    }
}
