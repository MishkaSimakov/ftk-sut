<?php
declare(strict_types=1);

namespace App\Achievements\Articles;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class LikeSelfArticle extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Самолайк - залог успеха!';

    /*
     * A small description for the achievement
     */
    public $description = 'Оценить свою же статью.';
}
