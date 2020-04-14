<?php

namespace App\Achievements\Events;

use App\Article;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserLikeArticle
{
    use Dispatchable, SerializesModels;

    public $article;
    public $user;


    public function __construct(User $user, Article $article)
    {
        $this->article = $article;
        $this->user = $user;
    }
}
