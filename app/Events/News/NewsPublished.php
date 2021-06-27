<?php

namespace App\Events\News;

use App\Models\News;
use Illuminate\Foundation\Events\Dispatchable;

/*
 * Это событие вызывается, когда новость опубликована.
 * Это происходит не при создании, а при наступлении срока публикации.
 * */
class NewsPublished
{
    use Dispatchable;

    public News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }
}
