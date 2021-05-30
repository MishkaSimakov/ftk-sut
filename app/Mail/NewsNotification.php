<?php

namespace App\Mail;

use App\Models\News;
use Illuminate\Mail\Mailable;

class NewsNotification extends Mailable
{
    protected News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function build()
    {
        return $this->subject('Новая новость на сайте ФТК СЮТ')->markdown('emails.news-notification', [
            'news' => $this->news,
        ]);
    }
}
