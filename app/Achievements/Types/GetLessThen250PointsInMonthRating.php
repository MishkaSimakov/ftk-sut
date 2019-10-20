<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class GetLessThen250PointsInMonthRating extends AchievementType
{
    public $description = '';
    public $icon = '';

    public function qualifier($point)
    {
        //
    }
}
