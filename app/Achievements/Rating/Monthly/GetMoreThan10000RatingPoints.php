<?php
declare(strict_types=1);

namespace App\Achievements\Rating\Monthly;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Rating
 */
class GetMoreThan10000RatingPoints extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Заявка на победу';

    /*
     * A small description for the achievement
     */
    public $description = 'Получить больше 10000 очков в ежемесячном рейтинге';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 10000;
}
