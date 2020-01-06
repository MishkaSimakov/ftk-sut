<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class WriteFirstArticle extends AchievementType
{
    public $name = 'Young writer';
    public $description = 'Write first article.';
    public $icon = 'https://www.jing.fm/clipimg/detail/107-1070395_relevant-images-by-achievement-png-achievement-free-icon.png';

    public function qualifier($article)
    {
        return true;
    }
}
