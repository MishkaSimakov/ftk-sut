<?php


namespace App\Achievements\Types;


use App\Achievements\AchievementType;

class Get1000PointsInMonthRating extends AchievementType
{
    public $name = 'Well done!';
    public $description = 'get 1000 points in montly rating';
    public $icon = 'https://www.jing.fm/clipimg/detail/107-1070395_relevant-images-by-achievement-png-achievement-free-icon.png';

    public function qualifier($point)
    {
        return $point->amount >= 1000;
    }
}
