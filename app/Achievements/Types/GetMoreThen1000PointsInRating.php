<?php


namespace App\Achievements\Types;


use App\Achievements\AchievementType;

class GetMoreThen1000PointsInRating extends AchievementType
{
    public $name = 'Начинающий новичок';
    public $description = 'Получить больше 1000 очков в рейтинге.';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($point)
    {
        $points = $point->student->points->where('rating_id', $point->rating_id);

        return $points->sum('amount') > 1000;
    }
}