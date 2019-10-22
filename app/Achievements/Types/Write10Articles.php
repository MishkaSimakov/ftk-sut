<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class Write10Articles extends AchievementType
{
    public $name = 'Super article writer!';
    public $description = 'Write 10 articles';
    public $icon = 'test-icon.svg';

    public function qualifier($article)
    {
        return count($article->user->articles) >= 10;
    }
}
