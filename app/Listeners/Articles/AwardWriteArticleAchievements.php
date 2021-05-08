<?php

namespace App\Listeners\Articles;

use App\Achievements\WriteArticleChain;
use App\Events\ArticleFirstTimePublished;

class AwardWriteArticleAchievements
{
    public function handle(ArticleFirstTimePublished $event)
    {
        $event->article->author->setProgress(new WriteArticleChain(),
            $event->article->author->articles()->published()->count()
        );
    }
}
