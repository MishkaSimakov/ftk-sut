<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Mail\Mailable;

class ArticleNotification extends Mailable
{
    protected Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function build()
    {
        return $this->subject('Новая статья на сайте ФТК СЮТ')->markdown('emails.article-notification', [
            'article' => $this->article,
        ]);
    }
}
