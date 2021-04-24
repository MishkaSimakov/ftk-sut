<?php
declare(strict_types=1);

namespace App\Achievements\Rating;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Rating
 */
class GetMoreThan1000RatingPoints extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Начинающий новичок';

    /*
     * A small description for the achievement
     */
    public $description = 'Получить больше 1000 очков в рейтинге.';
}
