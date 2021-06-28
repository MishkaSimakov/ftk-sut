<?php

namespace App\Notifications;

use App\Models\Article;
use App\Notifications\Traits\SendMultilinesTelegramMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class NewUncheckedArticleNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use SendMultilinesTelegramMessage;

    protected Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
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
            ->button('Непроверенные статьи', 'https://ftk-sut.ru/articles/unchecked');
    }

    protected function getMessageLines(): array
    {
        return [
            "Уважаемый администратор сайта ФТК СЮТ, появилась новая непроверенная статья:",
            $this->article->title,
        ];
    }
}
