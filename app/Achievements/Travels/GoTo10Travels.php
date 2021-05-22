<?php
declare(strict_types=1);

namespace App\Achievements\Travels;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Travels
 */
class GoTo10Travels extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Походы - это круто!';

    /*
     * A small description for the achievement
     */
    public $description = 'Сходите в 10 походов';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 10;
}
