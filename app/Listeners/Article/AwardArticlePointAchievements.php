<?php

namespace App\Listeners\Article;

use App\Achievements\Chains\ArticlePointChain;
use App\Achievements\Articles\Points\LikeSelfArticle;
use App\Events\Article\ArticleLiked;

class AwardArticlePointAchievements
{
    public function handle(ArticleLiked $event)
    {
        $event->user->setProgress(
            new ArticlePointChain(),
            $event->user->liked_articles()->count()
        );

        if ($event->article->author_id === $event->user->id) {
            $event->user->unlock(new LikeSelfArticle());
        }
    }
}
