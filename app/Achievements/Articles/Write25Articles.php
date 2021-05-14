<?php
declare(strict_types=1);

namespace App\Achievements\Articles;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class Write25Articles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Нечем заняться';

    /*
     * A small description for the achievement
     */
    public $description = 'Написать 25 статей';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 25;
}
