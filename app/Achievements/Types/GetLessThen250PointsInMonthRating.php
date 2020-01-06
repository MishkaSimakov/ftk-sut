<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class GetLessThen250PointsInMonthRating extends AchievementType
{
    public $description = '';
    public $icon = 'https://www.jing.fm/clipimg/detail/107-1070395_relevant-images-by-achievement-png-achievement-free-icon.png';

    public function qualifier($point)
    {
        //
    }
}
