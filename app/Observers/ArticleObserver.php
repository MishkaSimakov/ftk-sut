<?php

namespace App\Observers;

use App\Achievements\Articles\Write10Articles;
use App\Achievements\Articles\WriteFirstArticle;
use App\Models\Article;

class ArticleObserver
{
    /**
     * Handle the article "created" event.
     *
     * @param Article $article
     */
    public function created(Article $article)
    {
        $article->author->addProgress(new WriteFirstArticle());
        $article->author->addProgress(new Write10Articles());
    }

    /**
     * Handle the article "updated" event.
     *
     * @param Article $article
     */
    public function updated(Article $article)
    {
        //
    }

    /**
     * Handle the article "deleted" event.
     *
     * @param Article $article
     */
    public function deleted(Article $article)
    {
        $article->author->removeProgress(new WriteFirstArticle());
        $article->author->removeProgress(new Write10Articles());
    }

    /**
     * Handle the article "restored" event.
     *
     * @param Article $article
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the article "force deleted" event.
     *
     * @param Article $article
     */
    public function forceDeleted(Article $article)
    {
        //
    }
}
