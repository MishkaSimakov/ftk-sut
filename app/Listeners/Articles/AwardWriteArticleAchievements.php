<?php

namespace App\Listeners\Articles;

use App\Achievements\Chains\ArticleChain;
use App\Events\ArticleFirstTimePublished;

class AwardWriteArticleAchievements
{
    public function handle(ArticleFirstTimePublished $event)
    {
        $event->article->author->setProgress(new ArticleChain(),
            $event->article->author->articles()->published()->count()
        );
    }
}
