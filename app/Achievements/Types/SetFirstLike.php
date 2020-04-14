<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class SetFirstLike extends AchievementType
{
    public $name = 'Первый лайк';
    public $description = 'Оценить одну статью';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($article, $user)
    {
        return count($user->likedArticles) >= 1;
    }
}
