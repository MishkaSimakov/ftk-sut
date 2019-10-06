<?php


namespace App\Achievements\Types;


use App\Achievements\AchievementType;

class Get1000PointsInMonthRating extends AchievementType
{
    public $name = 'Well done!';
    public $description = 'get 1000 points in montly rating';
    public $icon = 'test-icon.svg';

    public function name()
    {
        return $this->name;
    }

    public function description() {
        return $this->description;
    }

    public function icon()
    {
        return $this->icon;
    }

    public function qualifier($point)
    {
        return $point->amount >= 1000;
    }
}
