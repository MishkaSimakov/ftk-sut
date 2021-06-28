<?php

namespace App\Notifications;

use App\Notifications\Traits\CanSendSelf;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class RatingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use CanSendSelf;

    protected Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->content(
                "На сайте ftk-sut.ru опубликован рейтинг за " . $this->date->isoFormat('MMMM YYYY')
            )
            ->options([
                'parse_mode' => 'html'
            ])
            ->button('Сайт ФТК', 'https://ftk-sut.ru')
            ->button('Рейтинг', 'https://ftk-sut.ru/rating');
    }
}
