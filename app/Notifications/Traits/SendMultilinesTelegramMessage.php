<?php


namespace App\Notifications\Traits;


trait SendMultilinesTelegramMessage
{
    protected function getParsedMessage(): string
    {
        $lines = $this->getMessageLines();

        $message = join("\n", $lines);

        return $this->removeProhibitedTags($message);
    }

    protected function removeProhibitedTags(string $message): string
    {
        return strip_tags(
            $message,
            config('services.telegram-bot-api.allowed_tags')
        );
    }

    abstract protected function getMessageLines(): array;
}
