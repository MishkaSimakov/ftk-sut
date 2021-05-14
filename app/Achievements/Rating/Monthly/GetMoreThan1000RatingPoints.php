<?php
declare(strict_types=1);

namespace App\Achievements\Rating\Monthly;

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
    public $description = 'Получить больше 1000 очков в ежемесячном рейтинге';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1000;
}
