<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class WriteFirstArticle extends AchievementType
{
    public $name = 'Кто-то научился писать!';
    public $description = 'Написать первую статью.';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($article)
    {
        return true;
    }
}
