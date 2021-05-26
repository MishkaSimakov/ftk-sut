<?php

namespace App\Events\News;

use App\Models\News;
use Illuminate\Foundation\Events\Dispatchable;

class NewsCreated
{
    use Dispatchable;

    public News $news;
    public bool $notify_users;

    public function __construct(News $news, bool $notify_users)
    {
        $this->news = $news;
        $this->notify_users = $notify_users;
    }
}
