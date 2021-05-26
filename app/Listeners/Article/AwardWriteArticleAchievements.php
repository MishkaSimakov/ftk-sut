<?php

namespace App\Listeners\Article;

use App\Achievements\Chains\ArticleChain;
use App\Events\Article\ArticleFirstTimeChecked;

class AwardWriteArticleAchievements
{
    public function handle(ArticleFirstTimeChecked $event)
    {
        $event->article->author->setProgress(new ArticleChain(),
            $event->article->author->articles()->checked()->count()
        );
    }
}
