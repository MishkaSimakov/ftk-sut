<?php
declare(strict_types=1);

namespace App\Achievements\Articles;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class Write5Articles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Местный репортёр';

    /*
     * A small description for the achievement
     */
    public $description = 'Написать 5 статей';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 5;
}
