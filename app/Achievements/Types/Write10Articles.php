<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class Write10Articles extends AchievementType
{
    public $name = 'Super article writer!';
    public $description = 'Write 10 articles';
    public $icon = 'https://www.jing.fm/clipimg/detail/107-1070395_relevant-images-by-achievement-png-achievement-free-icon.png';

    public function qualifier($article)
    {
        return count($article->user->articles) >= 10;
    }
}
