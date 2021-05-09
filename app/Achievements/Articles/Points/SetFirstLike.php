<?php
declare(strict_types=1);

namespace App\Achievements\Articles\Points;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class SetFirstLike extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Первые шаги';

    /*
     * A small description for the achievement
     */
    public $description = 'Оценить одну статью';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
