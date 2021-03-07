<?php

namespace App\Mail;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $news;

    /**
     * Create a new message instance.
     *
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->news->title)->markdown('emails.news.notification', [
            'news' => $this->news,
        ]);
    }
}
