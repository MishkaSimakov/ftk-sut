<?php

namespace App\Listeners\Articles;

use App\Events\ArticleFirstTimePublished;

class SendArticleNotificationEmail
{
    public function handle(ArticleFirstTimePublished $event)
    {
        // TODO: отправка email c оповещением о новой статье.
    }
}
