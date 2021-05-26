<?php

namespace App\Listeners\Article;

use App\Events\Article\ArticleFirstTimeChecked;

class SendArticleNotificationEmail
{
    public function handle(ArticleFirstTimeChecked $event)
    {
        // TODO: отправка email c оповещением о новой статье.
    }
}
