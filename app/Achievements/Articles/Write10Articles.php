<?php
declare(strict_types=1);

namespace App\Achievements\Articles;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class Write10Articles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Умелый писатель';

    /*
     * A small description for the achievement
     */
    public $description = 'Написать 10 статей.';
}
