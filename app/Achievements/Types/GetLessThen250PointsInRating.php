<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;

class GetLessThen250PointsInRating extends AchievementType
{
    public $name = 'В следующий раз повезёт';
    public $description = 'Получить меньше 250 очков в рейтинге.';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($rating, $student, $points)
    {
        return array_sum($points) < 250;
    }
}
