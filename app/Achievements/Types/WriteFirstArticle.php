<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class WriteFirstArticle extends AchievementType
{
    public $name = 'Young writer';
    public $description = 'Write first article.';
    public $icon = 'test-icon.svg';

    public function qualifier($article)
    {
        return true;
    }
}
