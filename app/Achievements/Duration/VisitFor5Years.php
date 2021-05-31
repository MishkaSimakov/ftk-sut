<?php
declare(strict_types=1);

namespace App\Achievements\Duration;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Travels
 */
class VisitFor5Years extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Пятилетний ветеран';

    /*
     * A small description for the achievement
     */
    public $description = 'Посещать клуб 5 лет';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 60;
}
