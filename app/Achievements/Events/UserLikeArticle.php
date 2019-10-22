<?php

namespace App\Achievements\Events;

use App\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserLikeArticle
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article;


    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
