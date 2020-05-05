<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class LikeSelfArticle extends AchievementType
{
    public $name = 'Самолайк - залог успеха!';
    public $description = 'Оценить свою же статью.';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($article, $user)
    {
        return $article->user_id === $user->id;
    }
}
