<?php

namespace App\Notifications;

use App\Models\News;
use App\Notifications\Traits\SendMultilinesTelegramMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class NewsPublishedNotification extends Notification
{
    use SendMultilinesTelegramMessage;

    protected News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->content($this->getParsedMessage())
            ->options([
                'parse_mode' => 'html'
            ])
            ->button('Сайт ФТК', 'https://ftk-sut.ru')
            ->button('Все новости', 'https://ftk-sut.ru/news');
    }

    protected function getMessageLines(): array
    {
        return [
            "Новая новость на сайте ftk-sut.ru:",
            "",
            "<b>{$this->news->title}</b>",
            $this->news->body
        ];
    }
}
