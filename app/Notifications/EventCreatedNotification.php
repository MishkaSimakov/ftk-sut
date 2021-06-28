<?php

namespace App\Notifications;

use App\Models\Event;
use App\Notifications\Traits\CanSendSelf;
use App\Notifications\Traits\SendMultilinesTelegramMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class EventCreatedNotification extends Notification implements ShouldQueue
{
    use SendMultilinesTelegramMessage;
    use Queueable;
    use CanSendSelf;

    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
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
            ->button('Все мероприятия', 'https://ftk-sut.ru/events');
    }

    protected function getMessageLines(): array
    {
        $event_name_string = "<b>{$this->event->name}</b>";

        if ($this->event->isTravel()) {
            $event_name_string .= " (" . ($this->event->travel->isHiking() ? "пеший" : "велосипедный") . " поход)";
        }

        return [
            "Новое мероприятие на сайте ftk-sut.ru:",
            "",
            $event_name_string,
            "<i>{$this->event->description}</i>",
            "<b>Начало:</b> {$this->event->dateStartForPage()}",
            "<b>Окончание:</b> {$this->event->dateEndForPage()}",
            "",
            "<i>Не забудьте записаться на сайте, если хотите прийти. Это поможет другим ученикам и преподавателям отслеживать список желающих.</i>"
        ];
    }
}
