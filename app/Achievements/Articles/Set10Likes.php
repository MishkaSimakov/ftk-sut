<?php
declare(strict_types=1);

namespace App\Achievements\Articles;

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
    public $description = 'Оценить 10 статей.';
}
