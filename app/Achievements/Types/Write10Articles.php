<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class Write10Articles extends AchievementType
{
    public $name = 'Умелый писатель';
    public $description = 'Написать 10 статей.';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($article)
    {
        return count($article->user->articles) >= 10;
    }
}
