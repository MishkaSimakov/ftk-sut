<?php
declare(strict_types=1);

namespace App\Achievements\Duration;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Travels
 */
class VisitForYear extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Добро пожаловать';

    /*
     * A small description for the achievement
     */
    public $description = 'Посещать клуб год';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 12;
}
