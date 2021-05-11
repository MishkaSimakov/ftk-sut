<?php

namespace App\Listeners\Articles;

use App\Events\ArticleFirstTimeChecked;

class SendArticleNotificationEmail
{
    public function handle(ArticleFirstTimeChecked $event)
    {
        // TODO: отправка email c оповещением о новой статье.
    }
}
