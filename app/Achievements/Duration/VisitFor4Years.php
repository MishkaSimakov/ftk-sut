<?php
declare(strict_types=1);

namespace App\Achievements\Duration;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Travels
 */
class VisitFor4Years extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Третья олимпиада';

    /*
     * A small description for the achievement
     */
    public $description = 'Посещать клуб 4 года';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 48;
}
