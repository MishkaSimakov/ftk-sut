<?php
declare(strict_types=1);

namespace App\Achievements\Duration;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Travels
 */
class VisitFor5Months extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Продолжай в том же духе';

    /*
     * A small description for the achievement
     */
    public $description = 'Посещать клуб полгода';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 5;
}
