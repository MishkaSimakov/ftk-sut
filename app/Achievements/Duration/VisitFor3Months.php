<?php
declare(strict_types=1);

namespace App\Achievements\Duration;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Travels
 */
class VisitFor3Months extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Испытательный срок';

    /*
     * A small description for the achievement
     */
    public $description = 'Посещать клуб 3 месяца';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 3;
}
