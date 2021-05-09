<?php
declare(strict_types=1);

namespace App\Achievements\Articles\Points;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class Set10Likes extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Профессиональный оценщик';

    /*
     * A small description for the achievement
     */
    public $description = 'Оценить 10 статей';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 10;
}
