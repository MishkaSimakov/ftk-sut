<?php
declare(strict_types=1);

namespace App\Achievements\Rating\Monthly;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Rating\Monthly
 */
class TakeThirdPlace extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Золото';

    /*
     * A small description for the achievement
     */
    public $description = 'Стать 1 по рейтингу за месяц';
}
